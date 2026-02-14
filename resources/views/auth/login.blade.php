@extends('layouts.app')

@section('title', 'Login - Ricimart')

@section('content')
<style>
    /* Modern Login Page Styles */
    .login-page-wrapper {
        background: transparent !important;
        min-height: 100vh;
        position: relative;
        overflow: hidden;
    }
    
    /* Animated Background Particles */
    .login-page-wrapper::before {
        content: '';
        position: fixed;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle at 20% 50%, rgba(255, 0, 204, 0.15) 0%, transparent 50%),
                    radial-gradient(circle at 80% 80%, rgba(51, 51, 255, 0.15) 0%, transparent 50%),
                    radial-gradient(circle at 40% 20%, rgba(0, 255, 238, 0.15) 0%, transparent 50%);
        animation: float 20s ease-in-out infinite;
        z-index: 0;
        top: -50%;
        left: -50%;
    }
    
    @keyframes float {
        0%, 100% { transform: translate(0, 0) rotate(0deg); }
        33% { transform: translate(30px, -30px) rotate(120deg); }
        66% { transform: translate(-20px, 20px) rotate(240deg); }
    }
    
    /* Login Container */
    .login-container {
        position: relative;
        z-index: 1;
        padding: 40px 0;
    }
    
    /* Modern Glass Card */
    .login-glass-card {
        background: rgba(255, 255, 255, 0.05) !important;
        backdrop-filter: blur(20px) !important;
        -webkit-backdrop-filter: blur(20px) !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        border-radius: 24px !important;
        padding: 40px !important;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3) !important;
        transition: all 0.4s ease !important;
    }
    
    .login-glass-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 48px rgba(0, 255, 238, 0.2) !important;
        border-color: rgba(0, 255, 238, 0.3) !important;
    }
    
    /* Credentials Box - Modern Design */
    .credentials-box {
        background: linear-gradient(135deg, rgba(255, 0, 204, 0.1), rgba(51, 51, 255, 0.1)) !important;
        backdrop-filter: blur(10px) !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        border-radius: 16px !important;
        padding: 20px !important;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
    }
    
    .credentials-box::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.05), transparent);
        animation: shine 3s infinite;
    }
    
    @keyframes shine {
        0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
        100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
    }
    
    .credentials-box * {
        position: relative;
        z-index: 1;
        color: white !important;
    }
    
    /* Modern Input Fields */
    .modern-input {
        background: rgba(255, 255, 255, 0.05) !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        border-radius: 12px !important;
        padding: 14px 18px !important;
        color: white !important;
        font-size: 16px !important;
        transition: all 0.3s ease !important;
        width: 100% !important;
    }
    
    .modern-input:focus {
        background: rgba(255, 255, 255, 0.08) !important;
        border-color: rgba(0, 255, 238, 0.5) !important;
        outline: none !important;
        box-shadow: 0 0 0 3px rgba(0, 255, 238, 0.1) !important;
        transform: translateY(-2px);
    }
    
    .modern-input::placeholder {
        color: rgba(255, 255, 255, 0.5) !important;
    }
    
    /* Gradient Button */
    .gradient-btn {
        background: linear-gradient(135deg, #ff00cc, #3333ff) !important;
        border: none !important;
        border-radius: 12px !important;
        padding: 16px 32px !important;
        color: white !important;
        font-weight: 600 !important;
        font-size: 16px !important;
        cursor: pointer !important;
        transition: all 0.3s ease !important;
        position: relative;
        overflow: hidden;
        width: 100%;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    .gradient-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }
    
    .gradient-btn:hover::before {
        left: 100%;
    }
    
    .gradient-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(255, 0, 204, 0.4) !important;
    }
    
    .gradient-btn:active {
        transform: translateY(0);
    }
    
    /* Secondary Button */
    .secondary-btn {
        background: rgba(255, 255, 255, 0.05) !important;
        border: 1px solid rgba(255, 255, 255, 0.2) !important;
        border-radius: 12px !important;
        padding: 16px 32px !important;
        color: white !important;
        font-weight: 600 !important;
        transition: all 0.3s ease !important;
        width: 100%;
        text-transform: uppercase;
        letter-spacing: 1px;
        text-decoration: none;
        display: block;
        text-align: center;
    }
    
    .secondary-btn:hover {
        background: rgba(255, 255, 255, 0.1) !important;
        border-color: rgba(0, 255, 238, 0.5) !important;
        transform: translateY(-2px);
        color: white !important;
    }
    
    /* Heading Styles */
    .modern-heading {
        font-size: 42px !important;
        font-weight: 700 !important;
        background: linear-gradient(135deg, #00ffee, #ff00cc) !important;
        -webkit-background-clip: text !important;
        -webkit-text-fill-color: transparent !important;
        background-clip: text !important;
        margin-bottom: 10px !important;
    }
    
    /* Text Styles */
    .modern-text {
        color: rgba(255, 255, 255, 0.8) !important;
        line-height: 1.6 !important;
        font-size: 16px !important;
    }
    
    /* Checkbox Modern Style */
    .modern-checkbox {
        accent-color: #00ffee !important;
        width: 18px !important;
        height: 18px !important;
        cursor: pointer !important;
    }
    
    /* Link Styles */
    .modern-link {
        color: #00ffee !important;
        text-decoration: none !important;
        transition: all 0.3s ease !important;
        font-weight: 500 !important;
    }
    
    .modern-link:hover {
        color: #ff00cc !important;
        text-decoration: underline !important;
    }
    
    /* Alert Messages */
    .alert-modern {
        border-radius: 12px !important;
        padding: 16px 20px !important;
        margin-bottom: 20px !important;
        backdrop-filter: blur(10px) !important;
        border: 1px solid !important;
    }
    
    .alert-success {
        background: rgba(34, 197, 94, 0.1) !important;
        border-color: rgba(34, 197, 94, 0.3) !important;
        color: #86efac !important;
    }
    
    .alert-error {
        background: rgba(239, 68, 68, 0.1) !important;
        border-color: rgba(239, 68, 68, 0.3) !important;
        color: #fca5a5 !important;
    }
    
    /* Breadcrumb Modern */
    .breadcrumb-modern {
        background: transparent !important;
    }
    
    .breadcrumb-modern * {
        color: white !important;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .login-glass-card {
            padding: 30px 20px !important;
        }
        
        .modern-heading {
            font-size: 32px !important;
        }
    }
</style>

<div class="login-page-wrapper">
    <div class="breadcrumb-block style-shared breadcrumb-modern">
        <div class="breadcrumb-main bg-linear overflow-hidden" style="background: transparent !important;">
            <div class="container lg:pt-[134px] pt-24 pb-10 relative">
                <div class="main-content w-full h-full flex flex-col items-center justify-center relative z-[1]">
                    <div class="text-content">
                        <div class="heading2 text-center modern-heading">Login</div>
                        <div class="link flex items-center justify-center gap-1 caption1 mt-3">
                            <a href="{{ route('home') }}" style="color: white !important;">Homepage</a>
                            <i class="ph ph-caret-right text-sm" style="color: rgba(255, 255, 255, 0.6) !important;"></i>
                            <div style="color: rgba(255, 255, 255, 0.6) !important;">Login</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="login-block md:py-20 py-10 login-container">
        <div class="container">
            <div class="content-main flex gap-y-8 max-md:flex-col">
                <!-- Left Side - Login Form -->
                <div class="left md:w-1/2 w-full lg:pr-[60px] md:pr-[40px]">
                    <div class="login-glass-card">
                        <div class="modern-heading" style="font-size: 36px; margin-bottom: 30px;">Welcome Back</div>
                        
                        @if(session('success'))
                            <div class="alert-modern alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        
                        @if(session('error'))
                            <div class="alert-modern alert-error" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif
                        
                        @if($errors->any())
                            <div class="alert-modern alert-error" role="alert">
                                <ul class="list-disc list-inside">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        <div class="credentials-box">
                            <div style="font-weight: 600; margin-bottom: 12px; font-size: 14px; text-transform: uppercase; letter-spacing: 1px;">🔐 Default Login Credentials</div>
                            <div style="font-size: 13px; margin-bottom: 8px;"><strong>User:</strong> john@example.com / password</div>
                            <div style="font-size: 13px;"><strong>Admin:</strong> admin@test.com / password</div>
                        </div>

                        <form method="POST" action="{{ route('login.submit') }}" class="md:mt-7 mt-4">
                            @csrf
                            <input type="hidden" name="redirect" value="{{ request()->get('redirect', route('home')) }}" />
                            
                            <div class="email mb-5">
                                <label for="email" style="display: block; margin-bottom: 8px; color: rgba(255, 255, 255, 0.9) !important; font-weight: 500;">Email Address</label>
                                <input class="modern-input @error('email') border-red-500 @enderror" id="email" name="email" type="email" placeholder="Enter your email address" value="{{ old('email') }}" required />
                            </div>
                            
                            <div class="pass mb-5">
                                <label for="password" style="display: block; margin-bottom: 8px; color: rgba(255, 255, 255, 0.9) !important; font-weight: 500;">Password</label>
                                <input class="modern-input @error('password') border-red-500 @enderror" id="password" name="password" type="password" placeholder="Enter your password" required />
                            </div>
                            
                            <div class="flex items-center justify-between mb-6">
                                <div class="flex items-center">
                                    <input type="checkbox" name="remember" id="remember" class="modern-checkbox" {{ old('remember') ? 'checked' : '' }} />
                                    <label for="remember" class="pl-2 cursor-pointer" style="color: rgba(255, 255, 255, 0.8) !important;">Remember me</label>
                                </div>
                                <a href="{{ route('forgot-password') }}" class="modern-link">Forgot Password?</a>
                            </div>
                            
                            <div class="block-button md:mt-7 mt-4">
                                <button type="submit" class="gradient-btn">Login</button>
                            </div>
                            
                            <div class="block-button mt-4">
                                <a href="{{ route('admin.login') }}" class="secondary-btn">Admin Login</a>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Right Side - New Customer -->
                <div class="right md:w-1/2 w-full lg:pl-[60px] md:pl-[40px] flex items-center">
                    <div class="login-glass-card">
                        <div class="modern-heading" style="font-size: 36px; margin-bottom: 20px;">New Customer?</div>
                        <div class="modern-text mb-6">
                            Join Ricimart today and unlock exclusive benefits! Get access to:
                        </div>
                        <ul style="list-style: none; padding: 0; margin-bottom: 30px;">
                            <li style="padding: 10px 0; color: rgba(255, 255, 255, 0.8) !important; display: flex; align-items: center;">
                                <span style="margin-right: 12px; font-size: 20px;">✨</span>
                                <span>Exclusive deals and discounts</span>
                            </li>
                            <li style="padding: 10px 0; color: rgba(255, 255, 255, 0.8) !important; display: flex; align-items: center;">
                                <span style="margin-right: 12px; font-size: 20px;">🚀</span>
                                <span>Fast checkout and order tracking</span>
                            </li>
                            <li style="padding: 10px 0; color: rgba(255, 255, 255, 0.8) !important; display: flex; align-items: center;">
                                <span style="margin-right: 12px; font-size: 20px;">🎁</span>
                                <span>Personalized recommendations</span>
                            </li>
                            <li style="padding: 10px 0; color: rgba(255, 255, 255, 0.8) !important; display: flex; align-items: center;">
                                <span style="margin-right: 12px; font-size: 20px;">💎</span>
                                <span>Early access to new products</span>
                            </li>
                        </ul>
                        <div class="block-button">
                            <a href="{{ route('register') }}" class="gradient-btn" style="text-decoration: none; display: block;">Create Account</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
