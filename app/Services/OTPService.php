<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
        $this->otpVariable = (string) config('services.msg91.otp_variable', 'OTP');
    }

    /**
     * Send OTP to mobile number using MSG91 API
     */
    public function sendOTP($mobile, $otp = null)
    {
        try {
            if (empty($mobile) || ! preg_match('/^[6-9]\d{9}$/', $mobile)) {
                return [
                    'success' => false,
                    'message' => 'Invalid mobile number format',
                    'error' => 'Mobile number must be 10 digits starting with 6-9',
                ];
            }

            if (! $otp) {
                $otp = random_int(100000, 999999);
            }

            $cacheKey = 'otp_'.$mobile;
            Cache::put($cacheKey, $otp, 600);

            Log::info('OTP Generated:', [
                'mobile' => $mobile,
                'otp' => $otp,
                'cache_key' => $cacheKey,
                'template_id' => $this->templateId,
                'otp_variable' => $this->otpVariable,
            ]);

            if (empty($this->authKey)) {
                Log::error('MSG91 Auth Key missing');

                return [
                    'success' => false,
                    'message' => 'SMS service configuration error',
                    'error' => 'MSG91 Auth Key not configured',
                ];
            }

            Log::info('MSG91 OTP Send Request:', [
                'mobile' => $mobile,
                'template_id' => $this->templateId,
                'has_template' => ! empty($this->templateId),
            ]);

            if (! empty($this->templateId) && $this->templateId !== 'your_template_id_here') {
                // 1) Official OTP API (best for ##OTP## templates)
                $result = $this->sendOtpApi($mobile, $otp);

                // 2) Flow API fallback (useful for ##number## / custom vars)
                if (! $result['success']) {
                    $result = $this->sendFlowOTP($mobile, $otp);
                }

                // 3) Legacy sendotp.php fallback
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

            if (config('app.env') === 'local' || config('app.debug')) {
                $result['otp'] = $otp;
                $result['debug_otp'] = $otp;
                $result['template_id'] = $this->templateId;
            }

            return $result;
        } catch (\Exception $e) {
            Log::error('MSG91 OTP Send Error:', [
                'mobile' => $mobile,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'success' => false,
                'message' => 'Failed to send OTP due to system error',
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Send OTP using MSG91 OTP API (recommended for ##OTP## templates)
     */
    private function sendOtpApi($mobile, $otp)
    {
        $payload = [
            'template_id' => $this->templateId,
            'mobile' => $this->country.$mobile,
            'otp' => (string) $otp,
            'otp_length' => 6,
            'otp_expiry' => 10,
        ];

        // Only needed when template placeholder is NOT ##OTP## (e.g. ##number##)
        $variable = trim($this->otpVariable);
        if ($variable !== '' && strcasecmp($variable, 'OTP') !== 0) {
            $payload['extra_param'] = [
                $variable => (string) $otp,
            ];
        }

        $response = Http::timeout(20)->withHeaders([
            'accept' => 'application/json',
            'authkey' => $this->authKey,
            'content-type' => 'application/json',
        ])->post('https://control.msg91.com/api/v5/otp', $payload);

        Log::info('MSG91 OTP API Response:', [
            'mobile' => $mobile,
            'template_id' => $this->templateId,
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
                'channel' => 'otp_api',
            ];
        }

        return [
            'success' => false,
            'message' => $this->getErrorMessage($responseData['message'] ?? 'Unknown error'),
            'error' => $responseData,
        ];
    }

    /**
     * Send OTP using MSG91 Flow API (custom template variables)
     */
    private function sendFlowOTP($mobile, $otp)
    {
        $recipient = [
            'mobiles' => $this->country.$mobile,
        ];

        // Send only the configured variable (+ common aliases), avoid dumping every alias.
        $aliases = array_unique(array_filter([
            $this->otpVariable,
            'OTP',
            'otp',
            'number',
            'var1',
        ]));

        foreach ($aliases as $key) {
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
            'variables_used' => array_keys($recipient),
        ]);

        $response = Http::timeout(20)->withHeaders([
            'accept' => 'application/json',
            'authkey' => $this->authKey,
            'content-type' => 'application/json',
        ])->post('https://control.msg91.com/api/v5/flow', $payload);

        Log::info('MSG91 Flow API Response:', [
            'mobile' => $mobile,
            'status' => $response->status(),
            'response' => $response->json() ?? $response->body(),
        ]);

        return $this->handleFlowResponse($response);
    }

    /**
     * Legacy MSG91 sendotp.php fallback — message must match approved DLT text.
     */
    private function sendSMSOTP($mobile, $otp)
    {
        // Matches old working DLT text that uses ##OTP##
        $message = "Your OTP for verification is {$otp}. Do not share this OTP with anyone. PADIA BRANDWORKS";

        $data = [
            'authkey' => $this->authKey,
            'mobile' => $this->country.$mobile,
            'message' => $message,
            'sender' => $this->senderId,
            'otp' => $otp,
            'otp_length' => 6,
            'otp_expiry' => 10,
            'route' => $this->route,
        ];

        Log::info('MSG91 SMS API Request:', [
            'mobile' => $mobile,
            'sender' => $this->senderId,
            'message' => $message,
        ]);

        $response = Http::timeout(20)->asForm()->post('https://control.msg91.com/api/sendotp.php', $data);

        Log::info('MSG91 SMS API Response:', [
            'mobile' => $mobile,
            'status' => $response->status(),
            'response' => $response->json() ?? $response->body(),
        ]);

        return $this->handleSMSResponse($response);
    }

    private function handleFlowResponse($response)
    {
        if (! $response->successful()) {
            return [
                'success' => false,
                'message' => 'Failed to send OTP: Network error',
                'error' => 'HTTP Status: '.$response->status(),
            ];
        }

        $responseData = $response->json();

        if (isset($responseData['type']) && $responseData['type'] === 'success') {
            return [
                'success' => true,
                'message' => 'OTP sent successfully',
                'request_id' => $responseData['message'] ?? null,
                'channel' => 'flow_api',
            ];
        }

        return [
            'success' => false,
            'message' => $this->getErrorMessage($responseData['message'] ?? 'Unknown error'),
            'error' => $responseData,
        ];
    }

    private function handleSMSResponse($response)
    {
        if (! $response->successful()) {
            return [
                'success' => false,
                'message' => 'Failed to send OTP: Network error',
                'error' => 'HTTP Status: '.$response->status(),
            ];
        }

        $responseData = $response->json();
        if (! is_array($responseData) && is_string($response->body())) {
            $responseData = json_decode($response->body(), true);
        }

        if (is_array($responseData) && ($responseData['type'] ?? '') === 'success') {
            return [
                'success' => true,
                'message' => 'OTP sent successfully',
                'request_id' => $responseData['message'] ?? null,
                'channel' => 'sms_api',
            ];
        }

        return [
            'success' => false,
            'message' => $this->getErrorMessage(is_array($responseData) ? ($responseData['message'] ?? 'Unknown error') : 'Unknown error'),
            'error' => $responseData,
        ];
    }

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

    public function verifyOTP($mobile, $otp)
    {
        try {
            if (empty($mobile) || empty($otp)) {
                return [
                    'success' => false,
                    'message' => 'Mobile number and OTP are required',
                ];
            }

            $cacheKey = 'otp_'.$mobile;
            $storedOTP = Cache::get($cacheKey);

            if (! $storedOTP) {
                return [
                    'success' => false,
                    'message' => 'OTP expired or not found. Please request a new OTP.',
                ];
            }

            if ((string) $storedOTP === (string) $otp) {
                Cache::forget($cacheKey);
                Cache::put('mobile_verified_'.$mobile, true, 3600);

                return [
                    'success' => true,
                    'message' => 'OTP verified successfully',
                ];
            }

            return [
                'success' => false,
                'message' => 'Invalid OTP. Please check and try again.',
            ];
        } catch (\Exception $e) {
            Log::error('OTP Verification Error:', [
                'mobile' => $mobile,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'OTP verification failed. Please try again.',
            ];
        }
    }

    public function isMobileVerified($mobile)
    {
        return Cache::has('mobile_verified_'.$mobile);
    }

    public function resendOTP($mobile)
    {
        try {
            $rateLimitKey = 'otp_rate_limit_'.$mobile;
            if (Cache::has($rateLimitKey)) {
                return [
                    'success' => false,
                    'message' => 'Please wait 60 seconds before requesting another OTP',
                ];
            }

            Cache::put($rateLimitKey, true, 60);

            return $this->sendOTP($mobile);
        } catch (\Exception $e) {
            Log::error('OTP Resend Error:', [
                'mobile' => $mobile,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'Failed to resend OTP. Please try again.',
            ];
        }
    }
}
