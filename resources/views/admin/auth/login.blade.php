<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - UBD</title>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #b72024 0%, #8a1519 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            display: flex;
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            max-width: 1000px;
            width: 100%;
            min-height: 550px;
        }

        /* Left Section - Branding */
        .left-section {
            flex: 1;
            background: linear-gradient(135deg, #b72024 0%, #d32f2f 100%);
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            position: relative;
            overflow: hidden;
        }

        .left-section::before {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: pulse 8s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.3; }
            50% { transform: scale(1.1); opacity: 0.5; }
        }

        .logo-container {
            width: 120px;
            height: 120px;
            background: #ffffff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 25px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
            animation: float 3s ease-in-out infinite;
            z-index: 1;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
        }

        .logo-container img {
            width: 80px;
            height: 80px;
            object-fit: contain;
        }

        .university-name {
            font-size: 36px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            z-index: 1;
        }

        .university-subtitle {
            font-size: 16px;
            text-align: center;
            opacity: 0.95;
            margin-bottom: 40px;
            z-index: 1;
        }

        .animated-illustration {
            width: 100%;
            max-width: 280px;
            z-index: 1;
            animation: slideUp 1.5s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Animated SVG - Gambar Gerak-Gerak */
        .lab-animation {
            width: 100%;
            max-width: 280px;
        }

        .lab-animation svg {
            width: 100%;
            height: auto;
        }

        /* Right Section - Form */
        .right-section {
            flex: 1;
            padding: 60px 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-title {
            font-size: 32px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }

        .login-subtitle {
            color: #666;
            margin-bottom: 40px;
            font-size: 15px;
        }

        .error-message {
            background: #fee;
            color: #c33;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            border-left: 4px solid #c33;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
            font-size: 14px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            font-size: 18px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 14px 15px 14px 45px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 15px;
            transition: all 0.3s ease;
            outline: none;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #b72024;
            box-shadow: 0 0 0 4px rgba(183, 32, 36, 0.1);
        }

        button[type="submit"] {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #b72024 0%, #d32f2f 100%);
            color: #ffffff;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(183, 32, 36, 0.3);
            margin-top: 10px;
        }

        button[type="submit"]:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(183, 32, 36, 0.4);
        }

        button[type="submit"]:active {
            transform: translateY(0);
        }

        .footer-text {
            text-align: center;
            margin-top: 30px;
            color: #999;
            font-size: 13px;
        }

        /* Icons using Unicode */
        .icon-user::before { content: '👤'; }
        .icon-lock::before { content: '🔒'; }

        /* Responsive */
        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
            }

            .left-section {
                padding: 40px 30px;
                min-height: 300px;
            }

            .right-section {
                padding: 40px 30px;
            }

            .university-name {
                font-size: 28px;
            }

            .login-title {
                font-size: 26px;
            }
        }
    </style>
</head>
<body>

<div class="login-container">
    <!-- Left Section - Branding with Animation -->
    <div class="left-section">
        <div class="logo-container">
            <!-- Ganti dengan logo universitas Anda -->
            <img src="{{ asset('./images/logo-UBD.png') }}" alt="Logo Univ UBD" onerror="this.style.display='none'; this.parentElement.innerHTML='<div style=\'font-size:48px;font-weight:bold;color:#b72024\'>UBD</div>'">
        </div>
        
        <h1 class="university-name">UBD</h1>
        <p class="university-subtitle">Lab Management System</p>
        
        <!-- Animated Illustration -->
        <div class="lab-animation">
            <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                <!-- Computer Monitor -->
                <rect x="50" y="60" width="100" height="70" rx="5" fill="#ffffff" opacity="0.9">
                    <animate attributeName="opacity" values="0.9;1;0.9" dur="2s" repeatCount="indefinite"/>
                </rect>
                <rect x="55" y="65" width="90" height="55" fill="#e3f2fd"/>
                
                <!-- Screen Content - Animated Lines -->
                <line x1="65" y1="75" x2="135" y2="75" stroke="#b72024" stroke-width="2">
                    <animate attributeName="x2" values="65;135;65" dur="3s" repeatCount="indefinite"/>
                </line>
                <line x1="65" y1="85" x2="120" y2="85" stroke="#b72024" stroke-width="2">
                    <animate attributeName="x2" values="65;120;65" dur="3.5s" repeatCount="indefinite"/>
                </line>
                <line x1="65" y1="95" x2="130" y2="95" stroke="#b72024" stroke-width="2">
                    <animate attributeName="x2" values="65;130;65" dur="2.8s" repeatCount="indefinite"/>
                </line>
                
                <!-- Monitor Stand -->
                <rect x="90" y="130" width="20" height="15" fill="#ffffff" opacity="0.9"/>
                <rect x="70" y="145" width="60" height="5" rx="2" fill="#ffffff" opacity="0.9"/>
                
                <!-- Floating Particles -->
                <circle cx="30" cy="40" r="3" fill="#ffffff" opacity="0.6">
                    <animate attributeName="cy" values="40;30;40" dur="2s" repeatCount="indefinite"/>
                </circle>
                <circle cx="170" cy="60" r="2" fill="#ffffff" opacity="0.6">
                    <animate attributeName="cy" values="60;50;60" dur="2.5s" repeatCount="indefinite"/>
                </circle>
                <circle cx="40" cy="120" r="2.5" fill="#ffffff" opacity="0.6">
                    <animate attributeName="cy" values="120;110;120" dur="3s" repeatCount="indefinite"/>
                </circle>
            </svg>
        </div>
    </div>

    <!-- Right Section - Login Form -->
    <div class="right-section">
        <h2 class="login-title">Welcome!</h2>
        <p class="login-subtitle">Please log in to access the system.</p>

        @if($errors->any())
            <div class="error-message">
                ⚠️ {{ $errors->first('login') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.post') }}">
            @csrf
            
            <div class="form-group">
                <label for="email">Email / Username</label>
                <div class="input-wrapper">
                    <span class="input-icon icon-user"></span>
                    <input type="text" 
                           id="email" 
                           name="email" 
                           placeholder="Enter your email or username" 
                           required 
                           autofocus>
                </div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrapper">
                    <span class="input-icon icon-lock"></span>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           placeholder="Enter your password" 
                           required>
                </div>
            </div>

            <button type="submit">
                🔐 Login
            </button>
        </form>

        <div class="footer-text">
            © {{ date('Y') }} UBD Lab Management System
        </div>
    </div>
</div>

</body>
</html>