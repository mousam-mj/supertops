<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ShiprocketService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ShippingController extends Controller
{
    /**
     * Calculate shipping charges (Shiprocket first, then Delhivery fallback, then flat fallback)
     */
    public function calculate(Request $request)
    {
        $request->validate([
            'pincode' => 'required|string|size:6',
            'weight' => 'nullable|numeric|min:0',
            'cod_amount' => 'nullable|numeric|min:0',
            'order_amount' => 'nullable|numeric|min:0',
        ]);

        $pincode = $request->pincode;
        $weight = (float) ($request->weight ?? 1);
        $codAmount = (float) ($request->cod_amount ?? 0);
        $orderAmount = (float) ($request->order_amount ?? 0);

        // 1) Try Shiprocket
        $shiprocket = app(ShiprocketService::class);
        if ($shiprocket->isConfigured()) {
            $result = $shiprocket->checkServiceability($pincode, $weight, $codAmount);
            if ($result['serviceable']) {
                return response()->json([
                    'success' => true,
                    'data' => $this->shippingResponse($pincode, $result['shipping_charge'], $result['estimated_days'], 'shiprocket', $orderAmount),
                ]);
            }
            // Don't return error immediately, fall through to other providers
            \Log::info('Shiprocket not serviceable for pincode: ' . $pincode . ', trying fallback providers');
        }

        // 2) Delhivery (legacy)
        $delhiveryEndpoint = config('services.delhivery.api_endpoint');
        $clientSecret = config('services.delhivery.client_secret');
        if ($delhiveryEndpoint && $clientSecret) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Token ' . $clientSecret,
                    'Content-Type' => 'application/json',
                ])->get("{$delhiveryEndpoint}/c/api/pin-codes/json/", ['filter_codes' => $pincode]);

                if ($response->successful()) {
                    $data = $response->json();
                    $serviceable = isset($data['delivery_codes']) && count($data['delivery_codes']) > 0;
                    if ($serviceable) {
                        $shippingCharge = $this->calculateShippingCharge($weight, $codAmount);

                        return response()->json([
                            'success' => true,
                            'data' => $this->shippingResponse($pincode, $shippingCharge, '3-5 business days', 'delhivery', $orderAmount),
                        ]);
                    }
                }
            } catch (\Exception $e) {
                \Log::error('Delhivery API error: ' . $e->getMessage());
            }
        }

        // 3) Flat fallback when no provider configured
        $shippingCharge = $this->calculateFallbackShipping($weight, $pincode);
        $estimatedDelivery = $this->getEstimatedDelivery($pincode);
        
        return response()->json([
            'success' => true,
            'data' => $this->shippingResponse($pincode, $shippingCharge, $estimatedDelivery, 'zone_based', $orderAmount),
        ]);
    }

    private function shippingResponse(string $pincode, float $shippingCharge, string $estimatedDelivery, string $provider, float $orderAmount): array
    {
        $freeShippingApplied = qualifies_for_free_shipping($orderAmount);

        return [
            'pincode' => $pincode,
            'serviceable' => true,
            'shipping_charge' => $freeShippingApplied ? 0 : round($shippingCharge, 2),
            'estimated_delivery' => $estimatedDelivery,
            'provider' => $provider,
            'free_shipping_applied' => $freeShippingApplied,
            'free_shipping_threshold' => free_shipping_threshold(),
        ];
    }

    private function calculateShippingCharge($weight, $codAmount = 0)
    {
        $baseCharge = 50;
        $weightCharge = max(0, ($weight - 1) * 10);
        $codCharge = $codAmount > 0 ? 20 : 0;
        return $baseCharge + $weightCharge + $codCharge;
    }

    private function calculateFallbackShipping($weight, $pincode = null)
    {
        $baseCharge = 50;
        $weightCharge = max(0, ($weight - 1) * 10);
        
        // Zone-based pricing for better accuracy
        if ($pincode) {
            $zone = $this->getPincodeZone($pincode);
            switch ($zone) {
                case 'local': // Same state (MP)
                    $baseCharge = 40;
                    break;
                case 'regional': // Nearby states
                    $baseCharge = 60;
                    break;
                case 'metro': // Metro cities
                    $baseCharge = 80;
                    break;
                case 'remote': // Far locations
                    $baseCharge = 100;
                    break;
                default:
                    $baseCharge = 50;
            }
        }
        
        return $baseCharge + $weightCharge;
    }
    
    private function getPincodeZone($pincode)
    {
        $firstThree = substr($pincode, 0, 3);
        
        // MP (local) - 452xxx, 462xxx, 482xxx etc
        if (in_array($firstThree, ['452', '462', '482', '486', '484', '485', '480', '481', '483'])) {
            return 'local';
        }
        
        // Regional (nearby states) - Gujarat, Rajasthan, Maharashtra
        if (in_array($firstThree, ['380', '390', '395', '302', '313', '324', '400', '411', '440'])) {
            return 'regional';
        }
        
        // Metro cities
        if (in_array($firstThree, ['110', '121', '122', '400', '560', '600', '700', '500'])) {
            return 'metro';
        }
        
        // Default to remote for other areas
        return 'remote';
    }
    
    private function getEstimatedDelivery($pincode)
    {
        $zone = $this->getPincodeZone($pincode);
        
        switch ($zone) {
            case 'local':
                return '1-2 business days';
            case 'regional':
                return '2-3 business days';
            case 'metro':
                return '3-4 business days';
            case 'remote':
                return '5-7 business days';
            default:
                return '3-5 business days';
        }
    }
}




