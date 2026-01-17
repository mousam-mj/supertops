@extends('layouts.app')

@section('title', 'Register - Perch Bottle')

@section('content')
<div class="auth-page md:pt-20 pt-10 pb-20">
    <div class="container">
        <div class="max-w-md mx-auto">
            <div class="bg-white border border-line rounded-2xl p-8">
                <h1 class="heading2 mb-6 text-center">Create Account</h1>
                
                @if($errors->any())
                    <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3 flex-1">
                                <h3 class="text-sm font-medium text-red-800">Please fix the following errors:</h3>
                                <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
                
                <form method="POST" action="{{ route('register.submit') }}" id="register-form" onsubmit="document.getElementById('submit-btn').disabled=true; document.getElementById('submit-btn').innerHTML='Creating Account...';">
                    @csrf
                    <input type="hidden" name="redirect" value="{{ request()->get('redirect', route('home')) }}">
                    
                    <div class="space-y-4">
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block caption1 text-secondary mb-2">First Name *</label>
                                <input type="text" name="first_name" value="{{ old('first_name') }}" class="w-full px-4 py-3 border border-line rounded-lg focus:border-black outline-none" required />
                                @error('first_name')
                                    <span class="caption1 text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="block caption1 text-secondary mb-2">Last Name *</label>
                                <input type="text" name="last_name" value="{{ old('last_name') }}" class="w-full px-4 py-3 border border-line rounded-lg focus:border-black outline-none" required />
                                @error('last_name')
                                    <span class="caption1 text-red-600">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <div>
                            <label class="block caption1 text-secondary mb-2">Email *</label>
                            <input type="email" name="email" value="{{ old('email') }}" class="w-full px-4 py-3 border {{ $errors->has('email') ? 'border-red-500' : 'border-line' }} rounded-lg focus:border-black outline-none transition-colors" required autocomplete="email" />
                            @error('email')
                                <span class="caption1 text-red-600 mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block caption1 text-secondary mb-2">Phone (Optional)</label>
                            <input type="tel" name="phone" value="{{ old('phone') }}" class="w-full px-4 py-3 border {{ $errors->has('phone') ? 'border-red-500' : 'border-line' }} rounded-lg focus:border-black outline-none transition-colors" placeholder="+1 234 567 8900" autocomplete="tel" />
                            @error('phone')
                                <span class="caption1 text-red-600 mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block caption1 text-secondary mb-2">Password *</label>
                            <input type="password" name="password" id="password" class="w-full px-4 py-3 border {{ $errors->has('password') ? 'border-red-500' : 'border-line' }} rounded-lg focus:border-black outline-none transition-colors" required autocomplete="new-password" />
                            <p class="caption2 text-secondary mt-1">Must be at least 8 characters long</p>
                            @error('password')
                                <span class="caption1 text-red-600 mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block caption1 text-secondary mb-2">Confirm Password *</label>
                            <input type="password" name="password_confirmation" class="w-full px-4 py-3 border {{ $errors->has('password_confirmation') ? 'border-red-500' : 'border-line' }} rounded-lg focus:border-black outline-none transition-colors" required autocomplete="new-password" />
                            @error('password_confirmation')
                                <span class="caption1 text-red-600 mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <button type="submit" id="submit-btn" class="w-full text-center block" style="background-color: #000; color: #fff; padding: 14px 24px; border-radius: 8px; font-weight: 600; cursor: pointer; border: none; transition: all 0.3s; font-size: 16px; display: block; width: 100%;" onmouseover="if(!this.disabled) this.style.backgroundColor='#333'" onmouseout="if(!this.disabled) this.style.backgroundColor='#000'">
                            Create Account
                        </button>
                    </div>
                </form>
                
                <div class="mt-6 text-center">
                    <p class="body2 text-secondary">
                        Already have an account?
                        <a href="{{ route('login') }}?redirect={{ urlencode(request()->get('redirect', route('home'))) }}" class="text-black hover:underline">
                            Login
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

