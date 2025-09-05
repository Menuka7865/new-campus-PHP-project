<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- Load custom CSS after Bootstrap so it can override Bootstrap defaults. Add a version to bust cache. -->
    <link rel="stylesheet" href="/SCM_System/app/style/signup.css?v=2">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <title>signup</title>
</head>

<body>
    <div class="header">
        <div class="headername">Colors of Excellence <div class="spanname">SUSL
                <button><a href="/SCM_System/app/pages/home.php">Home</a></button>
            </div>
        </div>
    </div>

    <div class="loginbox">
        <h1>Signup</h1>
        <form id="signupForm">
            <p>Full-name</p>
            <input type="text" id="fullname" name="fullname" placeholder="Enter full-name" required>
            <p>Email</p>
            <input type="text" id="email" name="email" placeholder="Enter Email" required>
            <p>Password</p>
            <input type="password" id="password" name="password" placeholder="Enter Password" required>
            <input type="submit" value="Signup">

            <div id="message" style="margin-top: 10px;"></div>

            <a href="/SCM_System/app/pages/login.php">Already have an account?</a>
        </form>
    </div>

    <script>
    document.getElementById('signupForm').addEventListener('submit', function(e) {
        e.preventDefault(); // Prevent default form submission

        // Get form data
        const name = document.getElementById('fullname').value;
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;

        // Prepare data for JSON submission
        const userData = {
            name: name,
            email: email,
            password: password
        };

        // Show loading message
        const messageDiv = document.getElementById('message');
        messageDiv.innerHTML = '<p style="color: blue;">Registering...</p>';

        // Send AJAX request to your PHP backend
        fetch('/SCM_System/app/api/signup.php', { // Update this path to match your backend file location
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(userData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    messageDiv.innerHTML = '<p style="color: green;text-align:center">' + data.message +
                        '</p>';
                    // Optionally redirect to login page after successful registration
                    setTimeout(function() {
                        window.location.href = '/SCM_System/app/pages/login.php';
                    }, 2000);
                } else {
                    messageDiv.innerHTML = '<p style="color: red;">Error: ' + data.message + '</p>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                messageDiv.innerHTML = '<p style="color: red;">An error occurred. Please try again.</p>';
            });
    });
    </script>
</body>

</html>