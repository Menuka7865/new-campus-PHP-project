<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/SCM_System/app/style/dashboard.css">
    <title>dashboard</title>
</head>

<body>
    <div>
        <?php
           require_once $_SERVER['DOCUMENT_ROOT'] . '/SCM_System/app/views/partials/nav.php';
        ?>
    </div>
    <div class="maincontent">
        <button><a href="/SCM_System/app/pages/home.php">Home</a></button>
        <h2>Admin dashboard</h2>
        <div class="subcontent">
            <div class="stdcount">
                <div class="label">Number Of Students</div>
                <div class="num">1000</div>
            </div>
            <div class="sports">
                <div class="label">Number Of Sports</div>
                <div class="num">25</div>
            </div>
        </div>


    </div>
</body>

</html>