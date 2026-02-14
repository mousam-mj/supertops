<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Ricimart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background: #0f0f0f !important;
            color: white;
            overflow-x: hidden;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
        }
        
        /* Animated Gradient Background */
        body::before {
            content: '';
            position: fixed;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, #ff00cc, #3333ff, #00ffee, #ff0066);
            background-size: 400% 400%;
            animation: gradientMove 12s ease infinite;
            z-index: -1;
            filter: blur(120px);
            opacity: 0.4;
            top: 0;
            left: 0;
        }
        
        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        /* Floating Accessories Background */
        .floating-accessories {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 0;
            pointer-events: none;
            overflow: hidden;
        }
        
        .accessory {
            position: absolute;
            font-size: 30px;
            opacity: 0.1;
            animation: floatAccessory 20s infinite ease-in-out;
        }
        
        .accessory:nth-child(1) { left: 10%; animation-delay: 0s; }
        .accessory:nth-child(2) { left: 30%; animation-delay: 2s; }
        .accessory:nth-child(3) { left: 50%; animation-delay: 4s; }
        .accessory:nth-child(4) { left: 70%; animation-delay: 6s; }
        .accessory:nth-child(5) { left: 90%; animation-delay: 8s; }
        
        @keyframes floatAccessory {
            0% { transform: translateY(100vh) rotate(0deg); opacity: 0; }
            10% { opacity: 0.1; }
            90% { opacity: 0.1; }
            100% { transform: translateY(-100vh) rotate(360deg); opacity: 0; }
        }
        
        .login-container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 450px;
        }
        
        .login-card {
            background: rgba(255, 255, 255, 0.05) !important;
            backdrop-filter: blur(20px) !important;
            -webkit-backdrop-filter: blur(20px) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            border-radius: 24px !important;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3) !important;
            overflow: hidden;
            transition: all 0.4s ease;
        }
        
        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 48px rgba(0, 255, 238, 0.2) !important;
            border-color: rgba(0, 255, 238, 0.3) !important;
        }
        
        .login-header {
            background: linear-gradient(135deg, rgba(255, 0, 204, 0.2), rgba(51, 51, 255, 0.2)) !important;
            backdrop-filter: blur(10px);
            color: white;
            padding: 40px 30px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
        }
        
        .login-header::before {
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
        
        .login-header h3 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
            background: linear-gradient(135deg, #00ffee, #ff00cc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            position: relative;
            z-index: 1;
        }
        
        .login-header p {
            color: rgba(255, 255, 255, 0.8);
            font-size: 14px;
            position: relative;
            z-index: 1;
        }
        
        .login-body {
            padding: 40px;
            background: transparent;
        }
        
        .form-label {
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 500;
            margin-bottom: 8px;
            font-size: 14px;
        }
        
        .input-group-text {
            background: rgba(255, 255, 255, 0.05) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            border-right: none !important;
            color: rgba(255, 255, 255, 0.7) !important;
        }
        
        .form-control {
            background: rgba(255, 255, 255, 0.05) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: white !important;
            padding: 12px 15px;
            border-radius: 12px !important;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            background: rgba(255, 255, 255, 0.08) !important;
            border-color: rgba(0, 255, 238, 0.5) !important;
            box-shadow: 0 0 0 3px rgba(0, 255, 238, 0.1) !important;
            outline: none !important;
            color: white !important;
        }
        
        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.5) !important;
        }
        
        .form-check-input {
            background-color: rgba(255, 255, 255, 0.05) !important;
            border-color: rgba(255, 255, 255, 0.2) !important;
            accent-color: #00ffee !important;
        }
        
        .form-check-input:checked {
            background-color: #00ffee !important;
            border-color: #00ffee !important;
        }
        
        .form-check-label {
            color: rgba(255, 255, 255, 0.8) !important;
        }
        
        .btn-login {
            background: linear-gradient(135deg, #ff00cc, #3333ff) !important;
            border: none !important;
            padding: 14px 24px !important;
            font-weight: 600 !important;
            font-size: 16px !important;
            border-radius: 12px !important;
            color: white !important;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            width: 100%;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }
        
        .btn-login:hover::before {
            left: 100%;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(255, 0, 204, 0.4) !important;
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .alert {
            background: rgba(239, 68, 68, 0.1) !important;
            border: 1px solid rgba(239, 68, 68, 0.3) !important;
            color: #fca5a5 !important;
            border-radius: 12px !important;
            padding: 16px 20px !important;
        }
        
        .alert ul {
            margin-bottom: 0;
        }
        
        .credentials-hint {
            background: linear-gradient(135deg, rgba(255, 0, 204, 0.1), rgba(51, 51, 255, 0.1)) !important;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 16px;
            margin-top: 20px;
            text-align: center;
        }
        
        .credentials-hint small {
            color: rgba(255, 255, 255, 0.7) !important;
            font-size: 13px;
        }
        
        .invalid-feedback {
            color: #fca5a5 !important;
            font-size: 12px;
            margin-top: 5px;
        }
        
        @media (max-width: 768px) {
            .login-card {
                margin: 0 10px;
            }
            
            .login-body {
                padding: 30px 20px;
            }
            
            .login-header {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Floating Accessories Background -->
    <div class="floating-accessories">
        <div class="accessory">📱</div>
        <div class="accessory">🔌</div>
        <div class="accessory">🔋</div>
        <div class="accessory">🎧</div>
        <div class="accessory">📱</div>
    </div>

    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <h3><i class="bi bi-shield-lock me-2"></i>Admin Login</h3>
                <p class="mb-0 mt-2">Ricimart Admin Panel</p>
            </div>
            <div class="login-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{{ route('admin.login') }}}">
                    @csrf

                    <div class="mb-4">
                        <label for="email" class="form-label">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email', 'admin@test.com') }}" 
                                   required 
                                   autofocus
                                   placeholder="Enter your email">
                        </div>
                        @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password" 
                                   required
                                   placeholder="Enter your password">
                        </div>
                        @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">
                            Remember me
                        </label>
                    </div>

                    <button type="submit" class="btn btn-login">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Login
                    </button>
                </form>

                <div class="credentials-hint">
                    <small>
                        <i class="bi bi-info-circle me-1"></i>
                        Default: admin@test.com / password
                    </small>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
