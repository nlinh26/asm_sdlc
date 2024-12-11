<?php
session_start();
include 'db.php';

// Kiểm tra quyền Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("You do not have access!");
}

// Lấy danh sách lớp học
$query_classes = "SELECT * FROM Classes";
$result_classes = $conn->query($query_classes);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Management</title>
    <link rel="stylesheet" href="class.css">
</head>
<body>
    <div class="sidebar">
        <h2>Admin Dashboard</h2>
        <a href="admin.php">Home</a>
        <a href="class.php">Class List</a>
        <a href="add_student.php">Add Student</a>
        <a href="login.php">Log Out</a>
    </div>

    <div class="content">
        <h1>Class Management</h1>
        
        <!-- Nút thêm lớp học -->
        <a href="add_class.php" class="add-class-button">Add New Class</a>

        <!-- Bảng danh sách lớp học -->
        <table>
            <thead>
                <tr>
                    <th>Class Code</th>
                    <th>Class Name</th>
                    <th>Number of Students</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($class = $result_classes->fetch_assoc()) { ?>
                    <tr>
                        <td><?= htmlspecialchars($class['class_code']) ?></td>
                        <td><?= htmlspecialchars($class['class_name']) ?></td>
                        <td><?= $class['num_students'] ?></td>
                        <td>
                            <a href="edit_class.php?id=<?= $class['id'] ?>">Edit</a> |
                            <a href="delete_class.php?id=<?= $class['id'] ?>" onclick="return confirm('Are you sure you want to delete this class?')">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
$conn->close();
?>
