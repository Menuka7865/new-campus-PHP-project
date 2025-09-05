<?php
        session_start();
        require_once $_SERVER['DOCUMENT_ROOT'] . '/SCM_System/app/api/db_connect.php';

        try {
            $stmt = $pdo->query("SELECT * FROM students_colors");
            $colors = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "<p>Error fetching student's color data: " . htmlspecialchars($e->getMessage()) . "</p>";
            $colors = [];
        }
        ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/SCM_System/app/style/manage_students.css">
    <title>Manage Student's color</title>
</head>
<style>
/* Modal styles - responsive for both mobile and desktop */
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(2px);
}

.modal-content {
    background-color: #fefefe;
    margin: 5% auto;
    padding: 20px;
    border: none;
    border-radius: 8px;
    width: 90%;
    max-width: 500px;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    animation: modalSlideIn 0.3s ease-out;
}

@keyframes modalSlideIn {
    from {
        transform: translateY(-50px);
        opacity: 0;
    }

    to {
        transform: translateY(0);
        opacity: 1;
    }
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
    line-height: 1;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
}

.modal h2 {
    margin-top: 0;
    color: #333;
    border-bottom: 2px solid #007bff;
    padding-bottom: 10px;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: #555;
}

.form-group input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
    box-sizing: border-box;
}

.form-group input:focus {
    border-color: #007bff;
    outline: none;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
}

.modal-buttons {
    display: flex;
    gap: 10px;
    margin-top: 20px;
    flex-wrap: wrap;
}

.btn {
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    min-width: 80px;
    transition: background-color 0.3s;
}

.btn-primary {
    background-color: #007bff;
    color: white;
}

.btn-primary:hover {
    background-color: #0056b3;
}

.btn-secondary {
    background-color: #6c757d;
    color: white;
}

.btn-secondary:hover {
    background-color: #545b62;
}

.btn-danger {
    background-color: #dc3545;
    color: white;
}

.btn-danger:hover {
    background-color: #c82333;
}

.delete-confirmation {
    text-align: center;
}

.delete-confirmation p {
    margin: 20px 0;
    font-size: 16px;
    color: #333;
}

.student-info {
    background-color: #f8f9fa;
    padding: 15px;
    border-radius: 4px;
    margin: 15px 0;
    border-left: 4px solid #dc3545;
}

.loading {
    display: none;
    text-align: center;
    padding: 20px;
}

.loading::after {
    content: '';
    width: 20px;
    height: 20px;
    border: 2px solid #f3f3f3;
    border-top: 2px solid #007bff;
    border-radius: 50%;
    display: inline-block;
    animation: spin 1s linear infinite;
    margin-left: 10px;
}

@keyframes spin {
    0% {
        transform: rotate(0deg);
    }

    100% {
        transform: rotate(360deg);
    }
}

.alert {
    padding: 10px;
    margin: 10px 0;
    border-radius: 4px;
    display: none;
}

.alert-success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.alert-error {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

/* Mobile responsiveness */
@media (max-width: 768px) {
    .modal-content {
        margin: 10% auto;
        padding: 15px;
        width: 95%;
    }

    .modal-buttons {
        flex-direction: column;
    }

    .btn {
        width: 100%;
        margin-bottom: 5px;
    }

    .form-group input {
        font-size: 16px;
        /* Prevents zoom on iOS */
    }
}

@media (max-width: 480px) {
    .modal-content {
        margin: 5% auto;
        padding: 10px;
    }

    .close {
        font-size: 24px;
    }
}
</style>

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
                    <?php if (!empty($colors)): ?>
                    <?php foreach ($colors as $color): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($color['student_id']); ?></td>
                        <td><?php echo htmlspecialchars($color['student_name']); ?></td>
                        <td><?php echo htmlspecialchars($color['sport']); ?></td>
                        <td><?php echo htmlspecialchars($color['color']); ?></td>
                        <td><?php echo htmlspecialchars($color['date']); ?></td>
                        <td>
                            <a href="#"
                                onclick="openEditModal('<?php echo htmlspecialchars($color['student_id']); ?>', '<?php echo htmlspecialchars($color['student_name']); ?>', '<?php echo htmlspecialchars($color['sport']); ?>', '<?php echo htmlspecialchars($color['color']); ?>', '<?php echo htmlspecialchars($color['date']); ?>')">
                                <img src="/SCM_System/app/assets/edit.png" alt="Edit" width="20" />
                            </a>
                            <a href="#"
                                onclick="openDeleteModal('<?php echo htmlspecialchars($color['student_id']); ?>', '<?php echo htmlspecialchars($color['student_name']); ?>')">
                                <img src="/SCM_System/app/assets/delete.png" alt="Delete" width="25" />
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="6">No students found.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeEditModal()">&times;</span>
            <h2>Edit Student's color</h2>
            <div id="editAlert" class="alert"></div>
            <form id="editForm">
                <div class="form-group">
                    <label for="editStudentId">Student ID:</label>
                    <input type="text" id="editStudentId" name="student_id" readonly />
                </div>
                <div class="form-group">
                    <label for="editStudentName">Name:</label>
                    <input type="text" id="editStudentName" name="student_name" required />
                </div>
                <div class="form-group">
                    <label for="editSport">Sport:</label>
                    <input type="text" id="editSport" name="sport" required />
                </div>
                <div class="form-group">
                    <label for="editColor">Color:</label>
                    <input type="text" id="editColor" name="color" required />
                </div>
                <div class="form-group">
                    <label for="editDate">Date:</label>
                    <input type="date" id="editDate" name="date" required />
                </div>
                <div class="modal-buttons">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <button type="button" class="btn btn-secondary" onclick="closeEditModal()">Cancel</button>
                </div>
            </form>
            <div id="editLoading" class="loading">Updating...</div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeDeleteModal()">&times;</span>
            <div class="delete-confirmation">
                <h2>Delete color</h2>
                <div id="deleteAlert" class="alert"></div>
                <p>Are you sure you want to delete this student's color?</p>
                <div class="student-info">
                    <p><strong>Student ID:</strong> <span id="deleteStudentId"></span></p>
                    <p><strong>Name:</strong> <span id="deleteStudentName"></span></p>
                </div>
                <div class="modal-buttons">
                    <button type="button" class="btn btn-danger" onclick="confirmDelete()">Yes, Delete</button>
                    <button type="button" class="btn btn-secondary" onclick="closeDeleteModal()">Cancel</button>
                </div>
                <div id="deleteLoading" class="loading">Deleting student...</div>
            </div>
        </div>
    </div>

    <script>
    let currentStudentId = '';

    // Edit Modal Functions
    function openEditModal(id, name, sport, color, date) {
        document.getElementById('editStudentId').value = id;
        document.getElementById('editStudentName').value = name;
        document.getElementById('editSport').value = sport;
        document.getElementById('editColor').value = color;
        document.getElementById('editDate').value = date;
        document.getElementById('editModal').style.display = 'block';
        hideAlert('editAlert');
    }

    function closeEditModal() {
        document.getElementById('editModal').style.display = 'none';
        document.getElementById('editForm').reset();
    }

    // Delete Modal Functions
    function openDeleteModal(id, name) {
        currentStudentId = id;
        document.getElementById('deleteStudentId').textContent = id;
        document.getElementById('deleteStudentName').textContent = name;
        document.getElementById('deleteModal').style.display = 'block';
        hideAlert('deleteAlert');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').style.display = 'none';
        currentStudentId = '';
    }

    // Alert Functions
    function showAlert(alertId, message, type) {
        const alert = document.getElementById(alertId);
        alert.textContent = message;
        alert.className = `alert alert-${type}`;
        alert.style.display = 'block';
    }

    function hideAlert(alertId) {
        document.getElementById(alertId).style.display = 'none';
    }

    // Update Student
    document.getElementById('editForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const loading = document.getElementById('editLoading');
        loading.style.display = 'block';
        hideAlert('editAlert');

        const formData = {
            student_id: document.getElementById('editStudentId').value,
            student_name: document.getElementById('editStudentName').value,
            sport: document.getElementById('editSport').value,
            color: document.getElementById('editColor').value,
            date: document.getElementById('editDate').value
        };

        try {
            const response = await fetch('/SCM_System/app/api/update_color.php', {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(formData)
            });

            const result = await response.json();
            loading.style.display = 'none';

            if (result.status === 'success') {
                showAlert('editAlert', result.message, 'success');
                setTimeout(() => {
                    location.reload(); // Refresh to show updated data
                }, 1500);
            } else {
                showAlert('editAlert', result.message, 'error');
            }
        } catch (error) {
            loading.style.display = 'none';
            showAlert('editAlert', 'Network error. Please try again.', 'error');
            console.error('Error:', error);
        }
    });

    // Delete Student
    async function confirmDelete() {
        const loading = document.getElementById('deleteLoading');
        loading.style.display = 'block';
        hideAlert('deleteAlert');

        try {
            const response = await fetch('/SCM_System/app/api/delete_color.php', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    student_id: currentStudentId
                })
            });

            const result = await response.json();
            loading.style.display = 'none';

            if (result.status === 'success') {
                showAlert('deleteAlert', result.message, 'success');
                setTimeout(() => {
                    location.reload(); // Refresh to show updated data
                }, 1500);
            } else {
                showAlert('deleteAlert', result.message, 'error');
            }
        } catch (error) {
            loading.style.display = 'none';
            showAlert('deleteAlert', 'Network error. Please try again.', 'error');
            console.error('Error:', error);
        }
    }

    // Close modals when clicking outside
    window.onclick = function(event) {
        const editModal = document.getElementById('editModal');
        const deleteModal = document.getElementById('deleteModal');

        if (event.target === editModal) {
            closeEditModal();
        }
        if (event.target === deleteModal) {
            closeDeleteModal();
        }
    }

    // Close modals with Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeEditModal();
            closeDeleteModal();
        }
    });
    </script>
</body>

</html>