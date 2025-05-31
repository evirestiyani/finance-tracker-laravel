<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - FinTrack</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f8fafc;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow-x: hidden;
            padding: 20px 0;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background:
                radial-gradient(circle at 20% 50%, rgba(71, 85, 105, 0.04) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(71, 85, 105, 0.03) 0%, transparent 50%),
                radial-gradient(circle at 40% 80%, rgba(71, 85, 105, 0.02) 0%, transparent 50%);
            pointer-events: none;
            z-index: 1;
        }

        .register-container {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 480px;
            padding: 20px;
            animation: fadeInUp 1s ease-out;
        }

        .register-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 24px;
            padding: 50px 40px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            position: relative;
            overflow: hidden;
        }

        .register-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, #e2e8f0, transparent);
        }

        .brand-header {
            text-align: center;
            margin-bottom: 40px;
            animation: fadeInDown 1s ease-out 0.2s both;
        }

        .brand-logo {
            font-family: 'Playfair Display', serif;
            font-size: 42px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 8px;
        }

        .brand-tagline {
            color: #64748b;
            font-size: 14px;
            font-weight: 300;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .register-subtitle {
            color: #475569;
            font-size: 16px;
            font-weight: 400;
            margin-top: 15px;
        }

        .error-messages {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 25px;
            animation: shake 0.5s ease-in-out;
        }

        .error-messages ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .error-messages li {
            color: #dc2626;
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
        }

        .error-messages li:last-child {
            margin-bottom: 0;
        }

        .error-messages i {
            font-size: 12px;
        }

        .register-form {
            animation: slideInUp 1s ease-out 0.4s both;
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-label {
            display: block;
            color: #374151;
            font-weight: 500;
            margin-bottom: 10px;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-control {
            width: 100%;
            padding: 18px 20px 18px 50px;
            background: #f8fafc;
            border: 1px solid #d1d5db;
            border-radius: 12px;
            color: #1e293b;
            font-size: 16px;
            transition: all 0.3s ease;
            position: relative;
        }

        .form-control:focus {
            outline: none;
            border-color: #6b7280;
            box-shadow: 0 0 0 3px rgba(107, 114, 128, 0.1);
            background: #ffffff;
        }

        .form-control::placeholder {
            color: #9ca3af;
        }

        .input-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 16px;
            z-index: 3;
        }

        .form-control:focus+.input-icon {
            color: #6b7280;
        }

        .btn-register {
            width: 100%;
            padding: 18px 24px;
            background: #1e293b;
            border: none;
            border-radius: 12px;
            color: #ffffff;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.4s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            overflow: hidden;
            margin-bottom: 25px;
        }

        .btn-register::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.6s;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 40px rgba(30, 41, 59, 0.3);
            background: #334155;
        }

        .btn-register:hover::before {
            left: 100%;
        }

        .btn-register:active {
            transform: translateY(0);
        }

        .register-footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 25px;
            border-top: 1px solid #e2e8f0;
            animation: fadeInUp 1s ease-out 0.6s both;
        }

        .login-link {
            color: #64748b;
            font-size: 14px;
            text-decoration: none;
            font-weight: 400;
            transition: all 0.3s ease;
        }

        .login-link:hover {
            color: #1e293b;
            text-decoration: underline;
        }

        .login-link strong {
            color: #1e293b;
            font-weight: 600;
        }

        .floating-elements {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            overflow: hidden;
            pointer-events: none;
            z-index: 1;
        }

        .floating-element {
            position: absolute;
            width: 60px;
            height: 60px;
            background: rgba(71, 85, 105, 0.05);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        .floating-element:nth-child(1) {
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .floating-element:nth-child(2) {
            top: 60%;
            right: 15%;
            animation-delay: 2s;
            width: 40px;
            height: 40px;
        }

        .floating-element:nth-child(3) {
            bottom: 20%;
            left: 20%;
            animation-delay: 4s;
            width: 30px;
            height: 30px;
        }

        .floating-element:nth-child(4) {
            top: 10%;
            right: 25%;
            animation-delay: 1s;
            width: 50px;
            height: 50px;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-5px);
            }

            75% {
                transform: translateX(5px);
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(180deg);
            }
        }

        @media (max-width: 480px) {
            .register-container {
                padding: 15px;
            }

            .register-card {
                padding: 40px 30px;
            }

            .brand-logo {
                font-size: 36px;
            }
        }
    </style>
</head>

<body>
    <div class="floating-elements">
        <div class="floating-element"></div>
        <div class="floating-element"></div>
        <div class="floating-element"></div>
        <div class="floating-element"></div>
    </div>

    <div class="register-container">
        <div class="register-card">
            <div class="brand-header">
                <div class="brand-logo">FinTrack</div>
                <div class="brand-tagline">Financial Management</div>
                <div class="register-subtitle">Create your account and start managing your finances</div>
            </div>

            @if ($errors->any())
                <div class="error-messages">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li><i class="fas fa-exclamation-circle"></i>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ url('/register') }}" class="register-form">
                @csrf

                <div class="form-group">
                    <label class="form-label">Full Name</label>
                    <div style="position: relative;">
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" 
                            placeholder="Enter your full name..." required autofocus>
                        <i class="fas fa-user input-icon"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <div style="position: relative;">
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}" 
                            placeholder="Enter your email..." required>
                        <i class="fas fa-envelope input-icon"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Password</label>
                    <div style="position: relative;">
                        <input type="password" class="form-control" name="password" 
                            placeholder="Create a strong password..." required>
                        <i class="fas fa-lock input-icon"></i>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Confirm Password</label>
                    <div style="position: relative;">
                        <input type="password" class="form-control" name="password_confirmation" 
                            placeholder="Confirm your password..." required>
                        <i class="fas fa-shield-alt input-icon"></i>
                    </div>
                </div>

                <button type="submit" class="btn-register">
                    <i class="fas fa-user-plus" style="margin-right: 8px;"></i>
                    Create Account
                </button>
            </form>

            <div class="register-footer">
                <p class="login-link">
                    Already have an account?
                    <strong><a href="{{ route('login') }}" style="color: inherit; text-decoration: none;">Sign in here</a></strong>
                </p>
            </div>
        </div>
    </div>
</body>
</html>