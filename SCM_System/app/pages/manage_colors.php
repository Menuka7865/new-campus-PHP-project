<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/SCM_System/app/style/manage_students.css">
    <title>Manage Student</title>
</head>

<body>
    <div>
        <?php
        require_once $_SERVER['DOCUMENT_ROOT'] . '/SCM_System/app/views/partials/nav.php';
        ?>
    </div>
    <div class="maincontent">
        <button><a href="/SCM_System/app/pages/dashboard.php">Dashboard</a></button>
        <h2>Manage Student's Colors</h2>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Std.Id</th>
                        <th>Name</th>
                        <th>Sport</th>
                        <th>Color</th>
                        <th>Date</th>
                        <th>Manage</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>xxx</td>
                        <td>xxx</td>
                        <td>xxxxxxxxx</td>
                        <td>xxxxxxxxx</td>
                        <td>xxxxxxxxx</td>
                        <td>
                            <a href="/SCM_System/app/pages/edit_student.php?id=xxx"><img
                                    src="/SCM_System/app/assets/edit.png" alt="Edit" width="20"></a>
                            <a href="/SCM_System/app/pages/delete_student.php?id=xxx"><img
                                    src="/SCM_System/app/assets/delete.png" alt="Delete" width="25"></a>
                        </td>
                    </tr>
                    <tr>
                        <td>xxx</td>
                        <td>xxx</td>
                        <td>xxxxxxxxx</td>
                        <td>xxxxxxxxx</td>
                        <td>xxxxxxxxx</td>
                        <td>
                            <a href="/SCM_System/app/pages/edit_student.php?id=xxx"><img
                                    src="/SCM_System/app/assets/edit.png" alt="Edit" width="20"></a>
                            <a href="/SCM_System/app/pages/delete_student.php?id=xxx"><img
                                    src="/SCM_System/app/assets/delete.png" alt="Delete" width="25"></a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>