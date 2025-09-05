<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="/SCM_System/app/style/dashboard.css" />
    <title>Admin Dashboard</title>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        fetch('/SCM_System/app/api/get_student_count.php')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                if (data.status === 'success') {
                    document.getElementById('studentCount').textContent = data.count;
                } else {
                    document.getElementById('studentCount').textContent = 'Error';
                    console.error('Backend error:', data.message);
                }
            })
            .catch(error => {
                document.getElementById('studentCount').textContent = 'Error';
                console.error('Fetch error:', error);
            });
    });
    </script>
</head>

<body>
    <div>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/SCM_System/app/views/partials/nav.php'; ?>
    </div>
    <div class="maincontent">
        <button><a href="/SCM_System/app/pages/home.php">Home</a></button>
        <h2>Admin dashboard</h2>
        <div class="subcontent">
            <div class="stdcount">
                <div class="label">Number Of Students</div>
                <div class="num" id="studentCount">Loading...</div>
            </div>
            <div class="sports">
                <div class="label">Number Of Sports</div>
                <div class="num">25</div>
            </div>
        </div>
    </div>
</body>

</html>