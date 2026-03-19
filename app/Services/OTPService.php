<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class OTPService
{
    private $authKey;
    private $senderId;
    private $route;
    private $country;

    public function __construct()
    {
        $this->authKey = config('services.msg91.auth_key');
        $this->senderId = config('services.msg91.sender_id');
        $this->route = config('services.msg91.route');
        $this->country = config('services.msg91.country');
    }

    /**
     * Send OTP to mobile number using MSG91 Flow API
     */
    public function sendOTP($mobile, $otp = null)
    {
        try {
            // Generate 6-digit OTP if not provided
            if (!$otp) {
                $otp = rand(100000, 999999);
            }

            // Store OTP in cache for 5 minutes
            $cacheKey = "otp_" . $mobile;
            Cache::put($cacheKey, $otp, 300); // 5 minutes

            // MSG91 Flow API endpoint
            $url = "https://control.msg91.com/api/v5/flow";

            $payload = [
                'template_id' => config('services.msg91.template_id', ''),
                'short_url' => '0',
                'realTimeResponse' => '1',
                'recipients' => [
                    [
                        'mobiles' => $this->country . $mobile,
                        'VAR1' => $otp, // Using VAR1 as shown in MSG91 docs
                        'OTP' => $otp,  // Also keep OTP for backward compatibility
                    ]
                ]
            ];

            $response = Http::withHeaders([
                'accept' => 'application/json',
                'authkey' => $this->authKey,
                'content-type' => 'application/json'
            ])->post($url, $payload);

            Log::info('MSG91 Flow OTP Send Response:', [
                'mobile' => $mobile,
                'status' => $response->status(),
                'response' => $response->json()
            ]);

            if ($response->successful()) {
                $responseData = $response->json();
                
                // Check if MSG91 returned success
                if (isset($responseData['type']) && $responseData['type'] === 'success') {
                    $result = [
                        'success' => true,
                        'message' => 'OTP sent successfully',
                        'request_id' => $responseData['message'] ?? null
                    ];
                    
                    // Only include OTP in development/testing mode for debugging
                    if (config('app.env') === 'local' || config('app.debug')) {
                        $result['otp'] = $otp; // For testing only - remove in production
                    }
                    
                    return $result;
                } else {
                    // MSG91 returned an error
                    return [
                        'success' => false,
                        'message' => 'Failed to send OTP: ' . ($responseData['message'] ?? 'Unknown error'),
                        'error' => $responseData
                    ];
                }
            } else {
                return [
                    'success' => false,
                    'message' => 'Failed to send OTP: ' . $response->body(),
                    'error' => $response->json()
                ];
            }
        } catch (\Exception $e) {
            Log::error('MSG91 OTP Send Error:', [
                'mobile' => $mobile,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'Failed to send OTP: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Verify OTP
     */
    public function verifyOTP($mobile, $otp)
    {
        try {
            $cacheKey = "otp_" . $mobile;
            $storedOTP = Cache::get($cacheKey);

            if (!$storedOTP) {
                return [
                    'success' => false,
                    'message' => 'OTP expired or not found'
                ];
            }

            if ($storedOTP == $otp) {
                // OTP verified, remove from cache
                Cache::forget($cacheKey);
                
                // Mark mobile as verified
                Cache::put("mobile_verified_" . $mobile, true, 3600); // 1 hour

                return [
                    'success' => true,
                    'message' => 'OTP verified successfully'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Invalid OTP'
                ];
            }
        } catch (\Exception $e) {
            Log::error('OTP Verification Error:', [
                'mobile' => $mobile,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'OTP verification failed: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Check if mobile is verified
     */
    public function isMobileVerified($mobile)
    {
        return Cache::has("mobile_verified_" . $mobile);
    }

    /**
     * Resend OTP
     */
    public function resendOTP($mobile)
    {
        // Check rate limiting
        $rateLimitKey = "otp_rate_limit_" . $mobile;
        if (Cache::has($rateLimitKey)) {
            return [
                'success' => false,
                'message' => 'Please wait before requesting another OTP'
            ];
        }

        // Set rate limit for 1 minute
        Cache::put($rateLimitKey, true, 60);

        return $this->sendOTP($mobile);
    }
}