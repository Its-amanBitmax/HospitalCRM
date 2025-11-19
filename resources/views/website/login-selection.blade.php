<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $hospital_name ?? 'Hospital' }} - Login Selection</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        body {
            background: linear-gradient(145deg, #0B717A, #2E939B, #0B717A);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            overflow-y: auto;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            display: flex;
            background: #FFFFFF;
            border-radius: 25px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.25);
            overflow: hidden;
            animation: fadeIn 0.8s ease-out;
            margin: 20px 0;
            position: relative;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .image-section {
            flex: 1.2;
            background: linear-gradient(rgba(11, 113, 122, 0.8), rgba(44, 193, 193, 0.7)),
                        url('https://images.unsplash.com/photo-1586773860418-d37222d8fce3?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80') no-repeat center center;
            background-size: cover;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 40px;
            color: white;
        }

        .image-content {
            position: relative;
            z-index: 2;
            max-width: 90%;
        }

        .image-section h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .image-section p {
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 30px;
            opacity: 0.9;
        }

        .features {
            list-style: none;
            margin-top: 30px;
        }

        .features li {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            font-size: 1rem;
        }

        .features i {
            margin-right: 12px;
            font-size: 1.2rem;
            color: #2CC1C1;
            background: white;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .content-section {
            flex: 1;
            padding: 40px;
            background: #FFFFFF;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .logo {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            justify-content: center;
        }

        .logo-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 12px;
            transition: transform 0.5s ease, box-shadow 0.3s ease;
            box-shadow: 0 5px 15px rgba(11, 113, 122, 0.3);
            object-fit: cover;
        }

        .logo-icon:hover {
            transform: rotate(360deg);
            box-shadow: 0 8px 25px rgba(11, 113, 122, 0.5);
        }

        .logo-text {
            font-size: 28px;
            font-weight: 700;
            color: #0B717A;
            letter-spacing: 1px;
        }

        .toggle-buttons {
            display: flex;
            width: 100%;
            max-width: 400px;
            margin-bottom: 30px;
            background: #f8f9fa;
            border-radius: 12px;
            padding: 5px;
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);
        }

        .toggle-btn {
            flex: 1;
            background: transparent;
            color: #666;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .toggle-btn.active {
            background: linear-gradient(to right, #0B717A, #2CC1C1);
            color: white;
            box-shadow: 0 2px 8px rgba(11, 113, 122, 0.3);
        }

        .toggle-btn i {
            margin-right: 8px;
            font-size: 1rem;
        }

        .login-card {
            width: 100%;
            max-width: 400px;
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            animation: fadeIn 0.8s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .welcome-text {
            text-align: center;
            margin-bottom: 25px;
        }

        .welcome-text h1 {
            font-size: 24px;
            color: #222;
            margin-bottom: 5px;
            font-weight: 600;
        }

        .welcome-text p {
            color: #666;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
            font-size: 14px;
        }

        .input-with-icon {
            position: relative;
        }

        .input-with-icon i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #0B717A;
            font-size: 1rem;
        }

        .form-group input {
            width: 100%;
            padding: 14px 14px 14px 45px;
            border: 2px solid #e1e5e9;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: #f9fafa;
        }

        .form-group input:focus {
            outline: none;
            border-color: #0B717A;
            box-shadow: 0 0 0 3px rgba(11, 113, 122, 0.15);
            background-color: white;
        }

        .form-group input::placeholder {
            color: #a7b1b2;
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #a7b1b2;
            cursor: pointer;
            font-size: 1rem;
        }

        .hint {
            font-size: 0.8rem;
            color: #a7b1b2;
            margin-top: 6px;
            display: flex;
            align-items: center;
        }

        .hint i {
            margin-right: 5px;
        }

        .auth-btn {
            width: 100%;
            padding: 16px;
            background: linear-gradient(to right, #0B717A, #2CC1C1);
            color: white;
            border: none;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
            position: relative;
            overflow: hidden;
        }

        .auth-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: all 0.6s;
        }

        .auth-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(11, 113, 122, 0.4);
        }

        .auth-btn:hover::before {
            left: 100%;
        }

        .auth-link {
            text-align: center;
            margin-top: 20px;
            font-size: 0.9rem;
        }

        .auth-link a {
            color: #0B717A;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .auth-link a:hover {
            color: #2CC1C1;
            text-decoration: underline;
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 25px 0;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #e1e5e9;
        }

        .divider span {
            padding: 0 15px;
            color: #a7b1b2;
            font-size: 0.9rem;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            color: #888;
            font-size: 0.8rem;
        }

        .footer a {
            color: #0B717A;
            text-decoration: none;
            font-weight: 500;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        @media (max-width: 992px) {
            .container {
                flex-direction: column;
                max-width: 90%;
            }

            .image-section {
                min-height: 300px;
                padding: 30px;
            }

            .image-section h1 {
                font-size: 2rem;
            }

            .content-section {
                padding: 40px 30px;
            }

            .logo-text {
                font-size: 28px;
            }

            h2 {
                font-size: 28px;
            }
        }

        @media (max-width: 576px) {
            .content-section {
                padding: 30px 20px;
            }

            .logo-icon {
                width: 50px;
                height: 50px;
                font-size: 24px;
            }

            .logo-text {
                font-size: 24px;
            }

            .btn {
                padding: 16px 20px;
                font-size: 15px;
            }

            .image-section {
                min-height: 250px;
                padding: 25px;
            }

            .image-section h1 {
                font-size: 1.8rem;
            }

            .features {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="image-section">
            <div class="image-content">
                <h1>Your Health, Our Priority</h1>
                <p>{{ $hospital_name ?? 'Hospital' }} provides comprehensive healthcare services with cutting-edge technology and compassionate care.</p>

                <ul class="features">
                    <li><i class="fas fa-check"></i> 24/7 Emergency Services</li>
                    <li><i class="fas fa-check"></i> Expert Medical Professionals</li>
                    <li><i class="fas fa-check"></i> Advanced Diagnostic Facilities</li>
                    <li><i class="fas fa-check"></i> Patient-Centered Care Approach</li>
                </ul>
            </div>
        </div>
        <div class="content-section">
            <div class="logo">
                <img class="logo-icon" src="{{ $logo ?? asset('assets/image/logo.png') }}" alt="{{ $hospital_name ?? 'Hospital' }} Logo">
                <div class="logo-text">{{ $hospital_name ?? 'Hospital' }}</div>
            </div>

            <div class="toggle-buttons">
                <button class="toggle-btn active" id="patient-toggle">
                    <i class="fas fa-user-injured"></i> Patient
                </button>
                <button class="toggle-btn" id="employee-toggle">
                    <i class="fas fa-user-md"></i> Employee
                </button>
            </div>

            <div class="login-card">
                <form id="login-form" method="POST" autocomplete="off">
                    @csrf
                    <div class="form-group">
                        <label for="login-identifier" id="identifier-label">Username</label>
                        <div class="input-with-icon">
                            <i class="fas fa-user" id="identifier-icon"></i>
                            <input type="text" id="login-identifier" placeholder="Enter your username" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="login-password">Password</label>
                        <div class="input-with-icon">
                            <i class="fas fa-lock"></i>
                            <input type="password" id="login-password" placeholder="Enter your password" required />
                            <button type="button" class="password-toggle" id="password-toggle">
                                <i class="far fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <button type="submit" class="auth-btn" id="login-btn">Login to Account</button>

                    <div class="divider"><span>or</span></div>

                    <div class="auth-link">
                        <a href="#" id="forgot-link"><i class="fas fa-key"></i> Forgot Password?</a>
                    </div>
                    <div class="auth-link" id="signup-link" style="margin-top:15px;">
                        Don't have an account? <a href="#">Sign Up Now</a>
                    </div>
                </form>
            </div>

            <div class="footer">
                <p>Need help? <a href="#">Contact Support</a> | &copy; {{ date('Y') }} {{ $hospital_name ?? 'Hospital' }}</p>
            </div>
        </div>
    </div>

<script>

// Toggle between patient and employee login
const patientToggle = document.getElementById('patient-toggle');
const employeeToggle = document.getElementById('employee-toggle');
const identifierLabel = document.getElementById('identifier-label');
const identifierIcon = document.getElementById('identifier-icon');
const identifierInput = document.getElementById('login-identifier');
const loginBtn = document.getElementById('login-btn');
const signupLink = document.getElementById('signup-link');

// Default: Patient Mode
function setPatientMode() {
    patientToggle.classList.add('active');
    employeeToggle.classList.remove('active');

    identifierLabel.textContent = 'Username';
    identifierIcon.className = 'fas fa-user';
    identifierInput.placeholder = 'Enter your username';

    loginBtn.textContent = 'Login to Account';
    signupLink.style.display = 'block';
}

function setEmployeeMode() {
    employeeToggle.classList.add('active');
    patientToggle.classList.remove('active');

identifierLabel.textContent = 'Employee Code';
identifierInput.placeholder = 'Enter your employee code';
identifierIcon.className = 'fas fa-id-card';

    loginBtn.textContent = 'Access Portal';
    signupLink.style.display = 'none';
}

patientToggle.addEventListener('click', setPatientMode);
employeeToggle.addEventListener('click', setEmployeeMode);


// ---------------------
// FORM SUBMIT
// ---------------------
document.getElementById('login-form').addEventListener('submit', function(e) {
    e.preventDefault();

    const identifier = identifierInput.value.trim();
    const password = document.getElementById('login-password').value;
    const isPatient = patientToggle.classList.contains('active');

    if (isPatient) {
        if (identifier === 'user123' && password === 'pass123') {
            successMessage("Login Successful!");
            setTimeout(() => window.location.href = '/patient/dashboard', 1200);
        } else {
            showError("Invalid Patient Credentials!");
        }
        return;
    }

    // Employee Login
    const formData = new FormData();
    formData.append('identifier', identifier);
    formData.append('password', password);
    formData.append('_token', document.querySelector('input[name="_token"]').value);

    fetch('/employee/userlogin', {
        method: 'POST',
        body: formData
    })
    .then(async res => {

        if (res.redirected) {
            window.location.href = res.url;
            return;
        }

        let data = await res.json();

        if (data.error) {
            showError(data.error);
        } else {
            showError("Invalid employee credentials");
        }
    })
    .catch(() => showError("Server error, please try again."));
});


// ---------------------
// SUCCESS UI
// ---------------------
function successMessage(msg) {
    const btn = document.querySelector('.auth-btn');
    btn.innerHTML = `<i class="fas fa-check-circle"></i> ${msg}`;
    btn.style.background = 'linear-gradient(to right, #4CAF50, #45a049)';
}


// ---------------------
// ERROR UI + Animation
// ---------------------
function showError(message) {
    const btn = document.querySelector('.auth-btn');
    const originalText = btn.textContent;

    btn.innerHTML = `<i class="fas fa-exclamation-circle"></i> ${message}`;
    btn.style.background = 'linear-gradient(to right, #f44336, #d32f2f)';

    setTimeout(() => {
        btn.innerHTML = originalText;
        btn.style.background = 'linear-gradient(to right, #0B717A, #2CC1C1)';
    }, 2000);

    const card = document.querySelector('.login-card');
    card.style.animation = 'shake 0.5s';
    setTimeout(() => card.style.animation = '', 500);
}


// ---------------------
// Password Toggle
// ---------------------
document.getElementById('password-toggle').addEventListener('click', function() {
    const pwd = document.getElementById('login-password');
    const icon = this.querySelector('i');

    if (pwd.type === 'password') {
        pwd.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        pwd.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
});


// Shake Animation Inject
const style = document.createElement('style');
style.textContent = `
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
        20%, 40%, 60%, 80% { transform: translateX(5px); }
    }
`;
document.head.appendChild(style);

</script>




</body>
</html>
