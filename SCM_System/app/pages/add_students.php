<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/SCM_System/app/style/add_student.css">
    <title>Add Student</title>
</head>

<body>
    <div>
        <?php
        require_once $_SERVER['DOCUMENT_ROOT'] . '/SCM_System/app/views/partials/nav.php';
        ?>
    </div>
    <div class="maincontent">
        <button><a href="/SCM_System/app/pages/dashboard.php">Dashboard</a></button>
        <h2>Add Student</h2>
        <div class="form-container">
            <form method="POST" id="addStudentForm">
                <label for="studentName">Student ID</label>
                <input type="text" id="studentID" name="studentName" required>
                <label for="studentID">Student's Name</label>
                <input type="text" id="studentName" name="studentID" required>
                <label for="faculty">Faculty</label>
                <input type="text" id="faculty" name="faculty" required>
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
                <input type="submit" value="ADD">
                <div id="message" style="margin-top: 10px;"></div>
            </form>
        </div>
    </div>
    <script>
    document.getElementById('addStudentForm').addEventListener('submit', function(e) {
        e.preventDefault(); // Prevent default form submission

        // Get form data
        const id = document.getElementById('studentID').value;
        const name = document.getElementById('studentName').value;
        const faculty = document.getElementById('faculty').value;
        const email = document.getElementById('email').value;


        // Prepare data for JSON submission
        const userData = {
            student_id: id,
            student_name: name,
            faculty: faculty,
            email: email,

        };

        // Show loading message
        const messageDiv = document.getElementById('message');
        messageDiv.innerHTML = '<p style="color: blue;">Adding...</p>';

        // Send AJAX request to your PHP backend
        fetch('/SCM_System/app/api/add_student.php', { // Update this path to match your backend file location
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
                        window.location.href = '/SCM_System/app/pages/add_students.php';
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