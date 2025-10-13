<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - System</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .login-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            max-width: 420px;
            width: 100%;
            padding: 40px;
            animation: slideUp 0.6s ease-out;
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

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-header h1 {
            font-size: 28px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 8px;
        }

        .login-header p {
            color: #666;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .input-wrapper {
            position: relative;
        }

        .form-group input {
            width: 100%;
            padding: 12px 16px 12px 40px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-group input:focus {
            outline: none;
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        .form-group input::placeholder {
            color: #999;
        }

        .input-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #667eea;
            font-size: 16px;
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #667eea;
            font-size: 16px;
            padding: 5px;
            transition: color 0.2s;
        }

        .toggle-password:hover {
            color: #764ba2;
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            font-size: 13px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
        }

        .remember-me input[type="checkbox"] {
            cursor: pointer;
            width: 16px;
            height: 16px;
            accent-color: #667eea;
        }

        .remember-me label {
            margin: 0;
            cursor: pointer;
            color: #666;
            font-size: 13px;
        }

        .forgot-password {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }

        .forgot-password:hover {
            color: #764ba2;
        }

        .login-btn {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 16px;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        .login-btn.loading {
            opacity: 0.8;
            pointer-events: none;
        }

        .spinner {
            display: inline-block;
            width: 14px;
            height: 14px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            margin-right: 8px;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .alert {
            padding: 12px 14px;
            border-radius: 8px;
            font-size: 13px;
            margin-bottom: 20px;
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-error {
            background: #fee;
            color: #c33;
            border: 1px solid #fcc;
        }

        .alert-success {
            background: #efe;
            color: #3c3;
            border: 1px solid #cfc;
        }

        .login-footer {
            text-align: center;
            margin-top: 20px;
            font-size: 13px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1>Welcome Back</h1>
            <p>Sign in to your account to continue</p>
        </div>

        <div id="alertBox"></div>

        <form id="loginForm" class="login-form">
            <div class="form-group">
                <label for="email">Email Address</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-envelope input-icon"></i>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        placeholder="you@example.com" 
                        required 
                        autocomplete="email">
                </div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-lock input-icon"></i>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        placeholder="Enter your password" 
                        required 
                        autocomplete="current-password">
                    <button type="button" class="toggle-password" id="togglePassword">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                </div>
            </div>

            <div class="form-options">
                <div class="remember-me">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Remember me</label>
                </div>
                <a href="forgot-password.php" class="forgot-password">Forgot Password?</a>
            </div>

            <button type="submit" class="login-btn" id="loginBtn">
                Sign In
            </button>
        </form>

        <div class="login-footer">
            <p>Don't have an account? <a href="register.php" style="color: #667eea; text-decoration: none; font-weight: 600;">Sign Up</a></p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            const emailInput = $('#email');
            const passwordInput = $('#password');
            const togglePasswordBtn = $('#togglePassword');
            const loginBtn = $('#loginBtn');
            const loginForm = $('#loginForm');
            const alertBox = $('#alertBox');

            // Toggle password visibility
            togglePasswordBtn.click(function(e) {
                e.preventDefault();
                const isPassword = passwordInput.attr('type') === 'password';
                passwordInput.attr('type', isPassword ? 'text' : 'password');
                $(this).find('i').toggleClass('fa-eye fa-eye-slash');
            });

            // Show alert message
            function showAlert(message, type = 'error') {
                alertBox.html(`
                    <div class="alert alert-${type}">
                        <i class="fa-solid fa-circle-info" style="margin-right: 8px;"></i>
                        ${message}
                    </div>
                `);
                alertBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }

            // Validate email
            function isValidEmail(email) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return emailRegex.test(email);
            }

            // Handle form submission
            loginForm.submit(function(e) {
                e.preventDefault();
                alertBox.empty();

                const email = emailInput.val().trim();
                const password = passwordInput.val();

                // Client-side validation
                if (!email) {
                    showAlert('Please enter your email address.', 'error');
                    emailInput.focus();
                    return;
                }

                if (!isValidEmail(email)) {
                    showAlert('Please enter a valid email address.', 'error');
                    emailInput.focus();
                    return;
                }

                if (!password) {
                    showAlert('Please enter your password.', 'error');
                    passwordInput.focus();
                    return;
                }

                if (password.length < 6) {
                    showAlert('Password must be at least 6 characters.', 'error');
                    passwordInput.focus();
                    return;
                }

                // Submit form via AJAX
                loginBtn.addClass('loading').prop('disabled', true);
                loginBtn.html('<span class="spinner"></span>Signing in...');

                $.ajax({
                    url: 'action/login-user.php',
                    type: 'POST',
                    data: {
                        email: email,
                        password: password,
                        remember: $('#remember').is(':checked') ? 1 : 0
                    },
                    dataType: 'json',
                    timeout: 5000,
                    success: function(response) {
                        if (response.dpl === true) {
                            setTimeout(() => {
                                window.location.href = 'index.php';
                            }, 1000);
                            showAlert('Login successful! Redirecting...', 'success');
                        } else {
                            const message = response.message || 'Login failed. Please try again.';
                            showAlert(message, 'error');
                            loginBtn.removeClass('loading').prop('disabled', false);
                            loginBtn.html('Sign In');
                            passwordInput.val('').focus();
                        }
                    },
                    error: function(xhr, status, error) {
                        showAlert('Connection error. Please try again.', 'error');
                        loginBtn.removeClass('loading').prop('disabled', false);
                        loginBtn.html('Sign In');
                    }
                });
            });

            // Clear alert when user starts typing
            emailInput.add(passwordInput).on('input', function() {
                alertBox.empty();
            });
        });
    </script>
</body>
</html>