<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login User - UBD Lab Management</title>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
            margin-bottom: 20px;
            z-index: 1;
        }

        .user-badge {
            background: rgba(255, 255, 255, 0.2);
            padding: 10px 20px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 30px;
            z-index: 1;
        }

        /* Student Illustration */
        .student-illustration {
            width: 100%;
            max-width: 250px;
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

        .student-illustration svg {
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

        .success-message {
            background: #d4edda;
            color: #155724;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            border-left: 4px solid #28a745;
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

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 14px 15px 14px 45px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 15px;
            transition: all 0.3s ease;
            outline: none;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        .remember-me {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .remember-me input[type="checkbox"] {
            margin-right: 8px;
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        .remember-me label {
            font-size: 14px;
            color: #666;
            cursor: pointer;
            margin: 0;
        }

        button[type="submit"] {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        button[type="submit"]:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }

        button[type="submit"]:active {
            transform: translateY(0);
        }

        .footer-links {
            text-align: center;
            margin-top: 25px;
            padding-top: 25px;
            border-top: 1px solid #e0e0e0;
        }

        .footer-links a {
            color: #667eea;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
        }

        .footer-links a:hover {
            text-decoration: underline;
        }

        .footer-text {
            text-align: center;
            margin-top: 20px;
            color: #999;
            font-size: 13px;
        }

        /* Icons using Unicode */
        .icon-email::before { content: '📧'; }
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
    <!-- Left Section - Branding -->
    <div class="left-section">
        <div class="logo-container">
            <img src="{{ asset('images/logo-UBD.png') }}" alt="Logo UBD" onerror="this.style.display='none'; this.parentElement.innerHTML='<div style=\'font-size:48px;font-weight:bold;color:#667eea\'>UBD</div>'">
        </div>
        
        <h1 class="university-name">UBD</h1>
        <p class="university-subtitle">Lab Management System</p>
        <div class="user-badge">👨‍🎓 Student & Faculty Portal</div>
        
        <!-- Student Illustration -->
        <div class="student-illustration">
            <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                <!-- Book/Laptop -->
                <rect x="60" y="80" width="80" height="60" rx="4" fill="#ffffff" opacity="0.9">
                    <animate attributeName="opacity" values="0.9;1;0.9" dur="2s" repeatCount="indefinite"/>
                </rect>
                <rect x="65" y="85" width="70" height="45" fill="#e8eaf6"/>
                
                <!-- Screen lines -->
                <line x1="75" y1="95" x2="125" y2="95" stroke="#667eea" stroke-width="2">
                    <animate attributeName="x2" values="75;125;75" dur="3s" repeatCount="indefinite"/>
                </line>
                <line x1="75" y1="105" x2="115" y2="105" stroke="#667eea" stroke-width="2">
                    <animate attributeName="x2" values="75;115;75" dur="3.5s" repeatCount="indefinite"/>
                </line>
                <line x1="75" y1="115" x2="120" y2="115" stroke="#667eea" stroke-width="2">
                    <animate attributeName="x2" values="75;120;75" dur="2.8s" repeatCount="indefinite"/>
                </line>
                
                <!-- Graduation Cap -->
                <polygon points="100,50 70,65 130,65" fill="#ffffff" opacity="0.9">
                    <animate attributeName="points" values="100,50 70,65 130,65;100,45 70,60 130,60;100,50 70,65 130,65" dur="3s" repeatCount="indefinite"/>
                </polygon>
                <rect x="95" y="65" width="10" height="25" fill="#ffffff" opacity="0.9"/>
                
                <!-- Floating Icons -->
                <circle cx="35" cy="60" r="3" fill="#ffffff" opacity="0.7">
                    <animate attributeName="cy" values="60;50;60" dur="2.5s" repeatCount="indefinite"/>
                </circle>
                <circle cx="165" cy="70" r="2.5" fill="#ffffff" opacity="0.7">
                    <animate attributeName="cy" values="70;60;70" dur="3s" repeatCount="indefinite"/>
                </circle>
                <circle cx="45" cy="130" r="2" fill="#ffffff" opacity="0.7">
                    <animate attributeName="cy" values="130;120;130" dur="2.8s" repeatCount="indefinite"/>
                </circle>
            </svg>
        </div>
    </div>

    <!-- Right Section - Login Form -->
    <div class="right-section">
        <h2 class="login-title">Login User</h2>
        <p class="login-subtitle">Log in to your account to access the lab</p>

        @if($errors->any())
            <div class="error-message">
                ⚠️ {{ $errors->first('login') }}
            </div>
        @endif

        @if(session('success'))
            <div class="success-message">
                ✓ {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('user.login.post') }}">
            @csrf
            
            <div class="form-group">
                <label for="email">Email</label>
                <div class="input-wrapper">
                    <span class="input-icon icon-email"></span>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="{{ old('email') }}"
                           placeholder="contoh@email.com" 
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
                           placeholder="Enter password" 
                           required>
                </div>
            </div>

            <div class="remember-me">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Remember Me</label>
            </div>

            <button type="submit">
                🚀 Enter the Lab
            </button>
        </form>

        <div class="footer-links">
            <a href="{{ route('admin.auth.login') }}">🔐 Login sebagai Admin</a>
        </div>

        <div class="footer-text">
            © {{ date('Y') }} UBD Lab Management System
        </div>
    </div>
</div>

</body>
</html>