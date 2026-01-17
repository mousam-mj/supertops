@extends('layouts.app')

@section('title', 'Register - Perch Bottle')

@section('content')
<div class="auth-page md:pt-20 pt-10 pb-20">
    <div class="container">
        <div class="max-w-md mx-auto">
            <div class="bg-white border border-line rounded-2xl p-8">
                <h1 class="heading2 mb-6 text-center">Create Account</h1>
                
                <form method="POST" action="{{ route('register.submit') }}">
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
                            <input type="email" name="email" value="{{ old('email') }}" class="w-full px-4 py-3 border border-line rounded-lg focus:border-black outline-none" required />
                            @error('email')
                                <span class="caption1 text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block caption1 text-secondary mb-2">Phone</label>
                            <input type="tel" name="phone" value="{{ old('phone') }}" class="w-full px-4 py-3 border border-line rounded-lg focus:border-black outline-none" />
                            @error('phone')
                                <span class="caption1 text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block caption1 text-secondary mb-2">Password *</label>
                            <input type="password" name="password" class="w-full px-4 py-3 border border-line rounded-lg focus:border-black outline-none" required />
                            @error('password')
                                <span class="caption1 text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block caption1 text-secondary mb-2">Confirm Password *</label>
                            <input type="password" name="password_confirmation" class="w-full px-4 py-3 border border-line rounded-lg focus:border-black outline-none" required />
                        </div>
                        
                        <button type="submit" class="button-main w-full text-center block">
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

