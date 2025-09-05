<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/SCM_System/app/style/add_colors.css">
    <title>Add colors</title>
</head>

<body>
    <div>
        <?php
        require_once $_SERVER['DOCUMENT_ROOT'] . '/SCM_System/app/views/partials/nav.php';
        ?>
    </div>
    <div class="maincontent">
        <button><a href="/SCM_System/app/pages/dashboard.php">Dashboard</a></button>
        <h2>Add Student's colors</h2>

        <div class="form-container">
            <form id="addStudentForm" method="POST">
                <label for="student_id">Student Id</label>
                <input type="text" id="student_id" name="student_id" required>

                <label for="student_name">Student's Name</label>
                <input type="text" id="student_name" name="student_name" required>

                <label for="faculty">Faculty</label>
                <input type="text" id="faculty" name="faculty" required>

                <label for="sport">Sport</label>
                <input type="text" id="sport" name="sport" required>

                <label for="color">Color</label>
                <input type="text" id="color" name="color" required>

                <label for="date">Date</label>
                <input type="date" id="date" name="date" required>

                <!-- ✅ Message inside form -->
                <div id="message" class="message" style="display:none;"></div>

                <button type="submit" id="submitBtn">ADD</button>
            </form>
        </div>
    </div>

    <script>
    document.getElementById('addStudentForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const submitBtn = document.getElementById('submitBtn');
        const messageDiv = document.getElementById('message');

        submitBtn.disabled = true;
        submitBtn.textContent = 'Adding...';

        const formData = new FormData(this);
        const jsonData = {};
        formData.forEach((value, key) => jsonData[key] = value);

        if (jsonData.date) {
            const dateObj = new Date(jsonData.date);
            jsonData.date = `${dateObj.getFullYear()}.${dateObj.getMonth() + 1}.${dateObj.getDate()}`;
        }

        fetch('/SCM_System/app/api/add_color.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(jsonData)
            })
            .then(response => response.json())
            .then(data => {
                messageDiv.style.display = 'block';
                if (data.status === 'success') {
                    messageDiv.className = 'message success';
                    messageDiv.textContent = data.message;
                    document.getElementById('addStudentForm').reset();
                } else {
                    messageDiv.className = 'message error';
                    messageDiv.textContent = data.message;
                }
                setTimeout(() => {
                    messageDiv.style.display = 'none';
                }, 5000);
            })
            .catch(error => {
                console.error('Error:', error);
                messageDiv.style.display = 'block';
                messageDiv.className = 'message error';
                messageDiv.textContent = 'An error occurred while adding the student.';
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.textContent = 'ADD';
            });
    });
    </script>

    <style>
    .message {
        padding: 10px;
        margin: 10px 0;
        border-radius: 4px;
        font-weight: bold;
    }

    .message.success {
        background-color: #d4edda;
        border: 1px solid #c3e6cb;
        color: #155724;
    }

    .message.error {
        background-color: #f8d7da;
        border: 1px solid #f5c6cb;
        color: #721c24;
    }

    button:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }
    </style>
</body>

</html>