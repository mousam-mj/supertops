<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ShippingController extends Controller
{
    /**
     * Calculate shipping charges
     */
    public function calculate(Request $request)
    {
        $request->validate([
            'pincode' => 'required|string|size:6',
            'weight' => 'nullable|numeric|min:0',
            'cod_amount' => 'nullable|numeric|min:0',
        ]);

        $pincode = $request->pincode;
        $weight = $request->weight ?? 1; // Default 1 kg
        $codAmount = $request->cod_amount ?? 0;

        // Check pincode serviceability using Delhivery API
        $delhiveryEndpoint = config('services.delhivery.api_endpoint');
        $clientId = config('services.delhivery.client_id');
        $clientSecret = config('services.delhivery.client_secret');

        if (!$delhiveryEndpoint || !$clientId) {
            // Fallback calculation if Delhivery not configured
            $shippingCharge = $this->calculateFallbackShipping($weight);
            
            return response()->json([
                'success' => true,
                'data' => [
                    'pincode' => $pincode,
                    'serviceable' => true,
                    'shipping_charge' => $shippingCharge,
                    'estimated_delivery' => '3-5 business days',
                ],
            ]);
        }

        try {
            // Check pincode serviceability
            $response = Http::withHeaders([
                'Authorization' => 'Token ' . $clientSecret,
                'Content-Type' => 'application/json',
            ])->get("{$delhiveryEndpoint}/c/api/pin-codes/json/", [
                'filter_codes' => $pincode,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $serviceable = isset($data['delivery_codes']) && count($data['delivery_codes']) > 0;

                if ($serviceable) {
                    // Calculate shipping charge (this is a placeholder - actual calculation depends on Delhivery API)
                    $shippingCharge = $this->calculateShippingCharge($weight, $codAmount);
                    
                    return response()->json([
                        'success' => true,
                        'data' => [
                            'pincode' => $pincode,
                            'serviceable' => true,
                            'shipping_charge' => $shippingCharge,
                            'estimated_delivery' => '3-5 business days',
                        ],
                    ]);
                }
            }
        } catch (\Exception $e) {
            \Log::error('Delhivery API error: ' . $e->getMessage());
        }

        // Pincode not serviceable or API error
        return response()->json([
            'success' => false,
            'message' => 'Pincode is not serviceable',
            'data' => [
                'pincode' => $pincode,
                'serviceable' => false,
            ],
        ], 400);
    }

    /**
     * Calculate shipping charge (placeholder - implement based on Delhivery pricing)
     */
    private function calculateShippingCharge($weight, $codAmount = 0)
    {
        // Basic calculation - replace with actual Delhivery pricing logic
        $baseCharge = 50; // Base shipping charge
        $weightCharge = max(0, ($weight - 1) * 10); // Additional charge per kg above 1kg
        $codCharge = $codAmount > 0 ? 20 : 0; // COD charge if applicable

        return $baseCharge + $weightCharge + $codCharge;
    }

    /**
     * Fallback shipping calculation
     */
    private function calculateFallbackShipping($weight)
    {
        return 50 + max(0, ($weight - 1) * 10);
    }
}




