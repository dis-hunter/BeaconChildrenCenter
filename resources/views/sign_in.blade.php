<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - Beacon Children Center</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: url('/images/recpt_lgn_enhanced.jpg') no-repeat center center/cover;
            font-family: Arial, sans-serif;
        }

        .login-container {
            background-color: white;
            margin-left :500px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 400px;
            padding: 30px;
            text-align: center;
        }

        .login-container img {
            width: 60px;
            margin-bottom: 10px;
        }

        .login-container h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .login-container label {
            display: block;
            font-size: 14px;
            text-align: left;
            margin-bottom: 5px;
        }

        .login-container input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        .login-container .login-btn {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        .login-container .login-btn:hover {
            background-color: #0056b3;
        }

        .login-container .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 15px 0;
        }

        .login-container .divider::before,
        .login-container .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #ccc;
        }

        .login-container .divider:not(:empty)::before {
            margin-right: 10px;
        }

        .login-container .divider:not(:empty)::after {
            margin-left: 10px;
        }

        .login-container .social-login {
            display: flex;
            justify-content: space-evenly;
            margin-bottom: 15px;
        }

        .login-container .social-login button {
            border: none;
            background-color: transparent;
            cursor: pointer;
        }

        .login-container .signup {
            font-size: 14px;
        }

        .login-container .signup a {
            color: #007bff;
            text-decoration: none;
        }

        .login-container .signup a:hover {
            text-decoration: underline;
        }
        .logo-header {
        display: flex; /* Enable flexbox layout */
        align-items: center; /* Vertically center items */
        gap: 10px; /* Add some space between the image and the heading */
    }

    .logo-header img {
        max-width: 50px; /* Adjust image size (example) */
        height: auto;
    }

    .logo-header h2 {
        margin: 0; /* Remove default margin from heading */
        font-size: 1.5rem; /* Adjust font size (optional) */
    }
    </style>
</head>
<body>



    <div class="login-container">
    <div class="container">
    <section class="row logo-header">
        <img src="/images/beacon_logo.jpg" alt="Beacon Logo">
        <h2>Beacon Children Center</h2>

    </section> </hr> </br>
</div>
        <form action="{{ route('register_child') }}" method="POST">
            @csrf
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Your email" required>

            <label for="password">Password</label>
<div style="position: relative; display: flex; align-items: center;">
    <input type="password" id="password" name="password" placeholder="Your Password" required style="width: 100%; padding-right: 40px;">
    <button type="button" id="togglePassword" 
        style="position: absolute; right: 10px; background: none; border: none; cursor: pointer; font-size: 14px;">👁️</button>
</div>

<script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordField = document.getElementById('password');

    togglePassword.addEventListener('click', function () {
        // Toggle the type attribute
        const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordField.setAttribute('type', type);
        // Change the button content (optional)
        this.textContent = type === 'password' ? '👁️' : '🙈';
    });
</script>


            <button type="submit" class="login-btn" style="background-color:#31b3e2 ;">Login</button>
        </form>

        <div class="divider">or</div>

        <div class="social-login">
          <button style="display: flex; align-items: center; gap: 8px; padding: 10px; border: none; background: none; cursor: pointer;">
    <img src="/images/google_icon.png" alt="Google" style="width: 20px; height: 20px;">
    <a href="" style="text-decoration: none; color: inherit; font-size: 14px;">Google</a>
</button>

        </div>

        
    </div>
</body>
</html>
