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
    private $templateId;

    private string $otpVariable;

    public function __construct()
    {
        $this->authKey = config('services.msg91.auth_key');
        $this->senderId = config('services.msg91.sender_id', 'PADIAB');
        $this->route = config('services.msg91.route', 4);
        $this->country = config('services.msg91.country', 91);
        $this->templateId = config('services.msg91.template_id');
        $this->otpVariable = config('services.msg91.otp_variable', 'var1');
    }

    /**
     * Send OTP to mobile number using MSG91 API
     */
    public function sendOTP($mobile, $otp = null)
    {
        try {
            // Validate mobile number
            if (empty($mobile) || !preg_match('/^[6-9]\d{9}$/', $mobile)) {
                return [
                    'success' => false,
                    'message' => 'Invalid mobile number format',
                    'error' => 'Mobile number must be 10 digits starting with 6-9'
                ];
            }

            // Generate 6-digit OTP if not provided
            if (!$otp) {
                $otp = rand(100000, 999999);
            }

            // Store OTP in cache for 10 minutes
            $cacheKey = "otp_" . $mobile;
            Cache::put($cacheKey, $otp, 600); // 10 minutes

            // Log OTP for debugging (remove in production)
            Log::info('OTP Generated:', [
                'mobile' => $mobile,
                'otp' => $otp,
                'cache_key' => $cacheKey
            ]);

            // Validate MSG91 configuration
            if (empty($this->authKey)) {
                Log::error('MSG91 Auth Key missing');
                return [
                    'success' => false,
                    'message' => 'SMS service configuration error',
                    'error' => 'MSG91 Auth Key not configured'
                ];
            }

            Log::info('MSG91 OTP Send Request:', [
                'mobile' => $mobile,
                'template_id' => $this->templateId,
                'has_template' => !empty($this->templateId)
            ]);

            // Prefer MSG91 OTP API, then Flow template, then legacy SMS fallback
            if (! empty($this->templateId) && $this->templateId !== 'your_template_id_here') {
                $result = $this->sendOtpApi($mobile, $otp);
                if (! $result['success']) {
                    $result = $this->sendFlowOTP($mobile, $otp);
                }
                // Always fallback to SMS if template-based methods fail to ensure OTP is delivered
                if (! $result['success']) {
                    Log::warning('MSG91 OTP/Flow failed, falling back to SMS API', [
                        'mobile' => $mobile,
                        'otp_error' => $result['error']['message'] ?? $result['message'] ?? '',
                    ]);
                    $result = $this->sendSMSOTP($mobile, $otp);
                }
            } else {
                $result = $this->sendSMSOTP($mobile, $otp);
            }

            // Add OTP to response for debugging in development (remove in production)
            if (config('app.env') === 'local' || config('app.debug')) {
                $result['otp'] = $otp;
                $result['debug_otp'] = $otp;
            }

            return $result;

        } catch (\Exception $e) {
            Log::error('MSG91 OTP Send Error:', [
                'mobile' => $mobile,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'message' => 'Failed to send OTP due to system error',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Send OTP using MSG91 OTP API (recommended for OTP templates)
     */
    private function sendOtpApi($mobile, $otp)
    {
        $response = Http::withHeaders([
            'accept' => 'application/json',
            'authkey' => $this->authKey,
            'content-type' => 'application/json',
        ])->post('https://control.msg91.com/api/v5/otp', [
            'template_id' => $this->templateId,
            'mobile' => $this->country.$mobile,
            'otp' => (string) $otp,
        ]);

        Log::info('MSG91 OTP API Response:', [
            'mobile' => $mobile,
            'status' => $response->status(),
            'response' => $response->json() ?? $response->body(),
        ]);

        if (! $response->successful()) {
            return [
                'success' => false,
                'message' => 'Failed to send OTP: Network error',
                'error' => 'HTTP Status: '.$response->status(),
            ];
        }

        $responseData = $response->json();
        if (is_array($responseData) && (($responseData['type'] ?? '') === 'success' || ($responseData['message'] ?? '') === 'OTP sent successfully')) {
            return [
                'success' => true,
                'message' => 'OTP sent successfully',
                'request_id' => $responseData['request_id'] ?? $responseData['message'] ?? null,
            ];
        }

        $errorMessage = $this->getErrorMessage($responseData['message'] ?? 'Unknown error');

        return [
            'success' => false,
            'message' => $errorMessage,
            'error' => $responseData,
        ];
    }

    /**
     * Send OTP using MSG91 Flow API (Template based)
     */
    private function sendFlowOTP($mobile, $otp)
    {
        $url = "https://control.msg91.com/api/v5/flow";

        $recipient = [
            'mobiles' => $this->country.$mobile,
        ];

        // Try multiple common variable names for MSG91 templates
        $otpVariables = array_filter([
            $this->otpVariable,
            'var1',
            'VAR1',
            '{{var1}}',
            '#var1#',
            'OTP',
            'otp',
            '{{otp}}',
            '#otp#',
            'code',
            '{{code}}',
            '#code#',
            'verification_code',
            '{{verification_code}}',
            '#verification_code#',
        ]);

        foreach ($otpVariables as $key) {
            $recipient[$key] = (string) $otp;
        }

        $payload = [
            'template_id' => $this->templateId,
            'short_url' => '0',
            'realTimeResponse' => '1',
            'recipients' => [$recipient],
        ];

        Log::info('MSG91 Flow API Request:', [
            'mobile' => $mobile,
            'template_id' => $this->templateId,
            'otp' => $otp,
            'variables_used' => array_keys($recipient),
        ]);

        $response = Http::withHeaders([
            'accept' => 'application/json',
            'authkey' => $this->authKey,
            'content-type' => 'application/json'
        ])->post($url, $payload);

        Log::info('MSG91 Flow API Response:', [
            'mobile' => $mobile,
            'status' => $response->status(),
            'response' => $response->json()
        ]);

        return $this->handleFlowResponse($response, $otp);
    }

    /**
     * Send OTP using MSG91 SMS API (Direct SMS)
     */
    private function sendSMSOTP($mobile, $otp)
    {
        $url = "https://control.msg91.com/api/sendotp.php";

        // Ensure OTP is clearly visible in the message
        $message = "Your verification code is {$otp}. Please keep it confidential. PADIA BRANDWORKS";

        $data = [
            'authkey' => $this->authKey,
            'mobile' => $this->country . $mobile,
            'message' => $message,
            'sender' => $this->senderId,
            'otp' => $otp,
            'route' => $this->route
        ];

        Log::info('MSG91 SMS API Request:', [
            'mobile' => $mobile,
            'otp' => $otp,
            'message' => $message,
            'sender' => $this->senderId
        ]);

        $response = Http::asForm()->post($url, $data);

        Log::info('MSG91 SMS API Response:', [
            'mobile' => $mobile,
            'status' => $response->status(),
            'response' => $response->body()
        ]);

        return $this->handleSMSResponse($response, $otp);
    }

    /**
     * Check if we should fallback to SMS API when Flow API fails
     */
    private function shouldFallbackToSMS(array $result): bool
    {
        // Always fallback to SMS for template issues to ensure OTP delivery
        return true;
    }

    /**
     * Handle MSG91 Flow API Response
     */
    private function handleFlowResponse($response, $otp)
    {
        if (!$response->successful()) {
            return [
                'success' => false,
                'message' => 'Failed to send OTP: Network error',
                'error' => 'HTTP Status: ' . $response->status()
            ];
        }

        $responseData = $response->json();

        if (isset($responseData['type'])) {
            if ($responseData['type'] === 'success') {
                return [
                    'success' => true,
                    'message' => 'OTP sent successfully',
                    'request_id' => $responseData['message'] ?? null
                ];
            } else {
                // Handle specific MSG91 errors
                $errorMessage = $this->getErrorMessage($responseData['message'] ?? 'Unknown error');
                return [
                    'success' => false,
                    'message' => $errorMessage,
                    'error' => $responseData
                ];
            }
        }

        return [
            'success' => false,
            'message' => 'Invalid response from SMS service',
            'error' => $responseData
        ];
    }

    /**
     * Handle MSG91 SMS API Response
     */
    private function handleSMSResponse($response, $otp)
    {
        if (!$response->successful()) {
            return [
                'success' => false,
                'message' => 'Failed to send OTP: Network error',
                'error' => 'HTTP Status: ' . $response->status()
            ];
        }

        $responseData = $response->json();

        if (isset($responseData['type']) && $responseData['type'] === 'success') {
            return [
                'success' => true,
                'message' => 'OTP sent successfully',
                'request_id' => $responseData['message'] ?? null
            ];
        }

        // Handle SMS API errors
        $errorMessage = $this->getErrorMessage($responseData['message'] ?? 'Unknown error');
        return [
            'success' => false,
            'message' => $errorMessage,
            'error' => $responseData
        ];
    }

    /**
     * Get user-friendly error messages
     */
    private function getErrorMessage($errorCode)
    {
        $errorMessages = [
            'Authentication failure' => 'SMS service authentication failed. Please try again.',
            'IP is not whitelisted' => 'Service temporarily unavailable. Please try again later.',
            'template id missing' => 'SMS template configuration error. Please contact support.',
            'Invalid template id' => 'SMS template configuration error. Please contact support.',
            'Invalid mobile number' => 'Please enter a valid mobile number.',
            'Mobile number is blacklisted' => 'This mobile number cannot receive SMS.',
            'Insufficient balance' => 'SMS service temporarily unavailable. Please try again later.',
            'Invalid sender id' => 'SMS service configuration error. Please contact support.',
        ];

        return $errorMessages[$errorCode] ?? 'Failed to send OTP. Please try again.';
    }

    /**
     * Verify OTP
     */
    public function verifyOTP($mobile, $otp)
    {
        try {
            // Validate inputs
            if (empty($mobile) || empty($otp)) {
                return [
                    'success' => false,
                    'message' => 'Mobile number and OTP are required'
                ];
            }

            $cacheKey = "otp_" . $mobile;
            $storedOTP = Cache::get($cacheKey);

            if (!$storedOTP) {
                return [
                    'success' => false,
                    'message' => 'OTP expired or not found. Please request a new OTP.'
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
                    'message' => 'Invalid OTP. Please check and try again.'
                ];
            }
        } catch (\Exception $e) {
            Log::error('OTP Verification Error:', [
                'mobile' => $mobile,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'OTP verification failed. Please try again.'
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
     * Resend OTP with rate limiting
     */
    public function resendOTP($mobile)
    {
        try {
            // Check rate limiting
            $rateLimitKey = "otp_rate_limit_" . $mobile;
            if (Cache::has($rateLimitKey)) {
                return [
                    'success' => false,
                    'message' => 'Please wait 60 seconds before requesting another OTP'
                ];
            }

            // Set rate limit for 1 minute
            Cache::put($rateLimitKey, true, 60);

            return $this->sendOTP($mobile);
        } catch (\Exception $e) {
            Log::error('OTP Resend Error:', [
                'mobile' => $mobile,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'Failed to resend OTP. Please try again.'
            ];
        }
    }
}