<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="icon" type="image/png" href="{{ \App\Models\Admin::first() && \App\Models\Admin::first()->logo ? asset('storage/' . \App\Models\Admin::first()->logo) : asset('image/Gemini_Generated_Image_xxqbl3xxqbl3xxqb.png') }}">
    <title>Super Admin Login | Hospital Management</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* ==== ANIMATED BACKGROUND IMAGE ==== */
        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color:blue
            z-index: -2;
            animation: bgZoom 9s ease-in-out infinite alternate;
            filter: brightness(0.75);
        }

        @keyframes bgZoom {
            0% {
                transform: scale(1);
            }
            100% {
                transform: scale(1.1);
            }
        }

        /* Optional overlay tint for better visibility */
        body::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 124, 145, 0.45);
            z-index: -1;
            mix-blend-mode: overlay;
        }

        /* ==== CONTAINER ==== */
        .container {
            display: flex;
            justify-content: center;
            align-items: stretch;
            width: 70%;
            max-width: 1100px;
            height: 500px;
            border-radius: 20px;
            overflow: hidden;
            position: relative;
            z-index: 1;
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
        }

        /* ==== LEFT PANEL ==== */
        .left-panel {
            flex: 1;
            background: url('/image/Gemini_Generated_Image_edrhvoedrhvoedrh.png')
            center/cover no-repeat;
            transition: transform 0.6s ease;
        }

        .left-panel:hover {
            transform: scale(1.03);
        }

        /* ==== RIGHT PANEL ==== */
        .right-panel {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            background: rgba(255, 255, 255, 0.66);
            backdrop-filter: blur(15px);
            padding: 40px;
            transition: transform 0.6s ease;
        }

        .right-panel:hover {
            transform: scale(1.02);
        }

        /* ==== FORM BOX ==== */
        .form-box {
            width: 100%;
            max-width: 400px;
            background: rgba(255, 255, 255, 0.25);
            padding: 40px 35px;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
            color: #fff;
            animation: fadeIn 1s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #000000ff;
            font-weight: 600;
            letter-spacing: 1px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            color: #000000ff;
            font-weight: 500;
            font-size: 15px;
        }

        input {
            width: 100%;
            padding: 10px 12px;
            margin-bottom: 20px;
            border: none;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.95);
            color: #333;
            font-size: 15px;
            outline: none;
            transition: all 0.3s ease;
        }

        input:focus {
            box-shadow: 0 0 8px #00ACC1;
        }

        .btn {
            width: 100%;
            background: linear-gradient(90deg, #007C91, #00ACC1);
            color: white;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s ease;
        }

        .btn:hover {
            transform: scale(1.03);
            box-shadow: 0 4px 14px rgba(0, 172, 193, 0.6);
        }

        .forgot-password {
            text-align: right;
            margin-top: -10px;
            margin-bottom: 20px;
        }

        .forgot-password a {
            color: #000000ff;
            text-decoration: none;
            font-size: 14px;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }

        /* Error display */
        .error-box {
            margin-bottom: 20px;
            text-align: center;
            color: #ff6b6b;
            background: rgba(255, 255, 255, 0.9);
            padding: 10px;
            border-radius: 8px;
            font-size: 14px;
        }

        /* ==== RESPONSIVE ==== */
        @media (max-width: 900px) {
            .container {
                flex-direction: column;
                height: auto;
                width: 92%;
            }

            .left-panel {
                width: 100%;
                height: 300px;
            }

            .right-panel {
                width: 100%;
                height: auto;
                padding: 30px 20px;
            }

            .form-box {
                max-width: 100%;
                padding: 30px 25px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="left-panel"></div>

        <div class="right-panel">
            <div class="form-box">
                <h2>Welcome Back!</h2>

                @if ($errors->any())
                    <div class="error-box">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Login Form -->
                <div id="loginSection">
                    <form id="loginForm" method="POST" action="{{ route('admin.login') }}">
                        @csrf

                        <label for="email">Email ID</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Enter your email" required autofocus>

                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Enter password" required>

                        <div class="forgot-password">
                            <a href="#" onclick="showForgotPassword()">Forgot Password?</a>
                        </div>

                        <button type="submit" class="btn">Login</button>
                    </form>
                </div>

                <!-- Forgot Password Section -->
                <div id="forgotSection" style="display: none;">
                    <form id="forgotForm">
                        <label for="forgotEmail">Email ID</label>
                        <input type="email" id="forgotEmail" placeholder="Enter your email" required>

                        <button type="submit" class="btn">Send OTP</button>
                        <button type="button" onclick="showLogin()" class="btn" style="background: #ccc; margin-top: 10px;">Back to Login</button>
                    </form>
                </div>

                <!-- OTP Verification Section -->
                <div id="otpSection" style="display: none;">
                    <form id="otpForm">
                        <label for="otp">Enter OTP</label>
                        <input type="text" id="otp" placeholder="Enter 6-digit OTP" required maxlength="6">

                        <button type="submit" class="btn">Verify OTP</button>
                        <button type="button" onclick="showForgotPassword()" class="btn" style="background: #ccc; margin-top: 10px;">Back</button>
                    </form>
                </div>

                <!-- Reset Password Section -->
                <div id="resetSection" style="display: none;">
                    <form id="resetForm">
                        <label for="newPassword">New Password</label>
                        <input type="password" id="newPassword" placeholder="Enter new password" required minlength="8">

                        <label for="confirmPassword">Confirm Password</label>
                        <input type="password" id="confirmPassword" placeholder="Confirm new password" required>

                        <button type="submit" class="btn">Reset Password</button>
                        <button type="button" onclick="showOtp()" class="btn" style="background: #ccc; margin-top: 10px;">Back</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById("loginForm").addEventListener("submit", function(e) {
            // Allow form submission to Laravel backend
            // No preventDefault here, as we want to submit to the route
        });

        function showForgotPassword() {
            document.getElementById('loginSection').style.display = 'none';
            document.getElementById('forgotSection').style.display = 'block';
            document.getElementById('otpSection').style.display = 'none';
            document.getElementById('resetSection').style.display = 'none';
        }

        function showLogin() {
            document.getElementById('loginSection').style.display = 'block';
            document.getElementById('forgotSection').style.display = 'none';
            document.getElementById('otpSection').style.display = 'none';
            document.getElementById('resetSection').style.display = 'none';
        }

        function showOtp() {
            document.getElementById('loginSection').style.display = 'none';
            document.getElementById('forgotSection').style.display = 'none';
            document.getElementById('otpSection').style.display = 'block';
            document.getElementById('resetSection').style.display = 'none';
        }

        function showReset() {
            document.getElementById('loginSection').style.display = 'none';
            document.getElementById('forgotSection').style.display = 'none';
            document.getElementById('otpSection').style.display = 'none';
            document.getElementById('resetSection').style.display = 'block';
        }

        // Forgot Password Form
        document.getElementById('forgotForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const email = document.getElementById('forgotEmail').value;

            fetch('/admin/forgot-password', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') || '{{ csrf_token() }}'
                },
                body: JSON.stringify({ email: email })
            })
            .then(response => response.json())
            .then(data => {
                if (data.message) {
                    alert(data.message);
                    showOtp();
                } else {
                    alert(data.error || 'Error sending OTP');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        });

        // OTP Verification Form
        document.getElementById('otpForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const otp = document.getElementById('otp').value;

            fetch('/admin/verify-otp', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') || '{{ csrf_token() }}'
                },
                body: JSON.stringify({ otp: otp })
            })
            .then(response => response.json())
            .then(data => {
                if (data.message) {
                    alert(data.message);
                    showReset();
                } else {
                    alert(data.error || 'Invalid OTP');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        });

        // Reset Password Form
        document.getElementById('resetForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const newPassword = document.getElementById('newPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            const email = document.getElementById('forgotEmail').value;

            if (newPassword !== confirmPassword) {
                alert('Passwords do not match');
                return;
            }

            fetch('/admin/reset-password', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') || '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    email: email,
                    password: newPassword,
                    password_confirmation: confirmPassword
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.message) {
                    alert(data.message);
                    showLogin();
                } else {
                    alert(data.error || 'Error resetting password');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        });
    </script>
</body>
</html>
