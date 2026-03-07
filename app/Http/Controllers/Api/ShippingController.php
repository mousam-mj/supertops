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
        ]);

        $pincode = $request->pincode;
        $weight = (float) ($request->weight ?? 1);
        $codAmount = (float) ($request->cod_amount ?? 0);

        // 1) Try Shiprocket
        $shiprocket = app(ShiprocketService::class);
        if ($shiprocket->isConfigured()) {
            $result = $shiprocket->checkServiceability($pincode, $weight, $codAmount);
            if ($result['serviceable']) {
                return response()->json([
                    'success' => true,
                    'data' => [
                        'pincode' => $pincode,
                        'serviceable' => true,
                        'shipping_charge' => $result['shipping_charge'],
                        'estimated_delivery' => $result['estimated_days'],
                        'provider' => 'shiprocket',
                    ],
                ]);
            }
            return response()->json([
                'success' => false,
                'message' => 'Pincode is not serviceable for delivery',
                'data' => ['pincode' => $pincode, 'serviceable' => false],
            ], 400);
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
                            'data' => [
                                'pincode' => $pincode,
                                'serviceable' => true,
                                'shipping_charge' => $shippingCharge,
                                'estimated_delivery' => '3-5 business days',
                                'provider' => 'delhivery',
                            ],
                        ]);
                    }
                }
            } catch (\Exception $e) {
                \Log::error('Delhivery API error: ' . $e->getMessage());
            }
        }

        // 3) Flat fallback when no provider configured
        $shippingCharge = $this->calculateFallbackShipping($weight);
        return response()->json([
            'success' => true,
            'data' => [
                'pincode' => $pincode,
                'serviceable' => true,
                'shipping_charge' => $shippingCharge,
                'estimated_delivery' => '3-5 business days',
                'provider' => 'flat',
            ],
        ]);
    }

    private function calculateShippingCharge($weight, $codAmount = 0)
    {
        $baseCharge = 50;
        $weightCharge = max(0, ($weight - 1) * 10);
        $codCharge = $codAmount > 0 ? 20 : 0;
        return $baseCharge + $weightCharge + $codCharge;
    }

    private function calculateFallbackShipping($weight)
    {
        return 50 + max(0, ($weight - 1) * 10);
    }
}




