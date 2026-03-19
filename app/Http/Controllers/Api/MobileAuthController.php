<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\OTPService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class MobileAuthController extends Controller
{
    private $otpService;

    public function __construct(OTPService $otpService)
    {
        $this->otpService = $otpService;
    }

    /**
     * Send OTP for registration
     */
    public function sendRegistrationOTP(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|digits:10|regex:/^[6-9]\d{9}$/',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            \Log::info('Registration OTP validation failed:', [
                'request_data' => $request->all(),
                'errors' => $validator->errors()->toArray()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 400);
        }

        $mobile = $request->mobile;
        
        // Check if mobile number already exists (check both formats)
        $existingUser = \App\Models\User::where('phone', $mobile)
                                        ->orWhere('phone', '+91' . $mobile)
                                        ->first();
        
        if ($existingUser) {
            return response()->json([
                'success' => false,
                'message' => 'Mobile number is already registered. Please use login instead.',
                'errors' => ['mobile' => ['This mobile number is already registered']]
            ], 400);
        }
        
        // Additional validation for email uniqueness
        $emailValidator = Validator::make($request->all(), [
            'email' => 'unique:users,email',
        ]);
        
        if ($emailValidator->fails()) {
            \Log::info('Email uniqueness validation failed:', [
                'email' => $request->email,
                'errors' => $emailValidator->errors()->toArray()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Email address is already registered',
                'errors' => $emailValidator->errors()
            ], 400);
        }

        $mobile = $request->mobile;
        
        try {
            $result = $this->otpService->sendOTP($mobile);

            if ($result['success']) {
                // Store registration data temporarily
                $registrationData = [
                    'name' => $request->name,
                    'mobile' => $mobile,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ];
                
                cache()->put("registration_data_" . $mobile, $registrationData, 600); // 10 minutes
                
                \Log::info('Registration OTP sent successfully:', [
                    'mobile' => $mobile,
                    'has_test_otp' => isset($result['otp'])
                ]);
            } else {
                \Log::error('Failed to send registration OTP:', [
                    'mobile' => $mobile,
                    'error' => $result
                ]);
            }

            return response()->json($result);
            
        } catch (\Exception $e) {
            \Log::error('Registration OTP send error:', [
                'mobile' => $mobile,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to send OTP due to system error. Please try again.',
                'error' => 'System error occurred'
            ], 500);
        }
    }

    /**
     * Verify OTP and complete registration
     */
    public function verifyAndRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|digits:10|regex:/^[6-9]\d{9}$/',
            'otp' => 'required|digits:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid input',
                'errors' => $validator->errors()
            ], 400);
        }

        $mobile = $request->mobile;
        $otp = $request->otp;

        // Verify OTP
        $otpResult = $this->otpService->verifyOTP($mobile, $otp);

        if (!$otpResult['success']) {
            return response()->json($otpResult);
        }

        // Get registration data from cache
        $registrationData = cache()->get("registration_data_" . $mobile);
        
        if (!$registrationData) {
            return response()->json([
                'success' => false,
                'message' => 'Registration session expired. Please start again.'
            ], 400);
        }

        try {
            // Create user
            $user = User::create([
                'name' => $registrationData['name'],
                'email' => $registrationData['email'],
                'phone' => $mobile,
                'password' => $registrationData['password'],
                'phone_verified_at' => now(),
            ]);

            // Clear registration data from cache
            cache()->forget("registration_data_" . $mobile);

            // Log the user in using Laravel's Auth system (for web session)
            Auth::login($user, true); // true = remember me

            // Generate token for API access
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Registration successful',
                'user' => $user,
                'token' => $token,
                'redirect_url' => route('home')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Registration failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Send OTP for login
     */
    public function sendLoginOTP(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|digits:10|regex:/^[6-9]\d{9}$/',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid mobile number',
                'errors' => $validator->errors()
            ], 400);
        }

        $mobile = $request->mobile;

        // Check if user exists (check both formats)
        $user = User::where('phone', $mobile)
                   ->orWhere('phone', '+91' . $mobile)
                   ->first();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Mobile number not registered. Please register first.'
            ], 404);
        }

        try {
            $result = $this->otpService->sendOTP($mobile);
            
            if ($result['success']) {
                \Log::info('Login OTP sent successfully:', [
                    'mobile' => $mobile,
                    'user_id' => $user->id,
                    'has_test_otp' => isset($result['otp'])
                ]);
            } else {
                \Log::error('Failed to send login OTP:', [
                    'mobile' => $mobile,
                    'user_id' => $user->id,
                    'error' => $result
                ]);
            }
            
            return response()->json($result);
            
        } catch (\Exception $e) {
            \Log::error('Login OTP send error:', [
                'mobile' => $mobile,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to send OTP due to system error. Please try again.',
                'error' => 'System error occurred'
            ], 500);
        }
    }

    /**
     * Verify OTP and login
     */
    public function verifyAndLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|digits:10|regex:/^[6-9]\d{9}$/',
            'otp' => 'required|digits:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid input',
                'errors' => $validator->errors()
            ], 400);
        }

        $mobile = $request->mobile;
        $otp = $request->otp;

        // Check if user exists (check both formats: '8839507322' and '+918839507322')
        $user = User::where('phone', $mobile)
                   ->orWhere('phone', '+91' . $mobile)
                   ->first();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Mobile number not registered. Please register first.'
            ], 404);
        }

        // Verify OTP
        $otpResult = $this->otpService->verifyOTP($mobile, $otp);

        if (!$otpResult['success']) {
            return response()->json($otpResult);
        }

        try {
            // Update phone verification if not already verified
            if (!$user->phone_verified_at) {
                $user->phone_verified_at = now();
                $user->save();
            }

            // Log the user in using Laravel's Auth system (for web session)
            \Auth::login($user, true); // true = remember me

            // Generate token for API access
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'user' => $user,
                'token' => $token,
                'redirect_url' => route('home')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Login failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Resend login OTP
     */
    public function resendLoginOTP(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|digits:10|regex:/^[6-9]\d{9}$/',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 400);
        }

        $mobile = $request->mobile;

        // Check if user exists (check both formats)
        $user = User::where('phone', $mobile)
                   ->orWhere('phone', '+91' . $mobile)
                   ->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Mobile number not registered. Please register first.'
            ], 400);
        }

        // Resend OTP using OTP Service
        $result = $this->otpService->resendOTP($mobile);

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'message' => 'OTP sent successfully'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => $result['message']
            ], 400);
        }
    }
}