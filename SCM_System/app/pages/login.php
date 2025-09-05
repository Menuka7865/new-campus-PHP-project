<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- Load custom CSS after Bootstrap so it can override Bootstrap defaults. Add a version to bust cache. -->
    <link rel="stylesheet" href="/SCM_System/app/style/login.css?v=2">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <title>Login</title>
</head>

<body>
    <div class="header">
        <div class="headername">Colors of Excellence
            <div class="spanname">SUSL
                <button><a href="/SCM_System/app/pages/home.php">Home</a></button>
            </div>
        </div>
    </div>

    <div class="loginbox">
        <h1>Login</h1>
        <form id="loginForm">
            <p>Email</p>
            <input type="text" id="email" name="email" placeholder="Enter Email" required>
            <p>Password</p>
            <input type="password" id="password" name="password" placeholder="Enter Password" required>
            <input type="submit" id="loginBtn" value="Login">

            <!-- Error/Success message display -->
            <div id="message" style="margin-top: 10px;"></div>

            <a href="#">Forgotten Password?</a><br>
            <a href="/SCM_System/app/pages/signup.php">Don't have an account?</a>
        </form>
    </div>

    <script>
    document.getElementById('loginForm').addEventListener('submit', async function(e) {
        e.preventDefault(); // Prevent default form submission

        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value;
        const messageDiv = document.getElementById('message');
        const loginBtn = document.getElementById('loginBtn');

        // Clear previous messages
        messageDiv.innerHTML = '';

        // Disable button during request
        loginBtn.disabled = true;
        loginBtn.value = 'Logging in...';

        // Basic client-side validation
        if (!email || !password) {
            showMessage('Please fill in all fields', 'error');
            resetButton();
            return;
        }

        if (!isValidEmail(email)) {
            showMessage('Please enter a valid email address', 'error');
            resetButton();
            return;
        }

        try {
            const response = await fetch('/SCM_System/app/api/login.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    email: email,
                    password: password
                })
            });

            const data = await response.json();

            if (data.status === 'success') {
                showMessage('Login successful! Redirecting...', 'success');

                // Store user data in sessionStorage (optional)
                sessionStorage.setItem('user', JSON.stringify(data.user));

                // Redirect to dashboard or home page after 1.5 seconds
                setTimeout(() => {
                    window.location.href =
                        '/SCM_System/app/pages/dashboard.php'; // Change to your dashboard page
                }, 1500);
            } else {
                showMessage(data.message, 'error');
                resetButton();
            }
        } catch (error) {
            console.error('Login error:', error);
            showMessage('An error occurred. Please try again.', 'error');
            resetButton();
        }
    });

    function showMessage(message, type) {
        const messageDiv = document.getElementById('message');
        const className = type === 'success' ? 'alert alert-success' : 'alert alert-danger';
        messageDiv.innerHTML = `<div class="${className}" role="alert">${message}</div>`;
    }

    function resetButton() {
        const loginBtn = document.getElementById('loginBtn');
        loginBtn.disabled = false;
        loginBtn.value = 'Login';
    }

    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
    </script>
</body>

</html>