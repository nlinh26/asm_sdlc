<?php
include 'db.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Bạn không có quyền truy cập!");
}

// Lấy danh sách người dùng
$users = $conn->query("SELECT * FROM Users");

if (!$users) {
    die("Lỗi truy vấn: " . $conn->error);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="bit.css">
</head>
<body>
<div class="sidebar">
    <h3>Hello Admin</h3>
    <a href="admin.php">Home</a>
    <a href="class.php">Class</a>
    <a href="add_teacher.php">Add Teacher</a>
    <a href="criteria.php">Manage evaluation criteria</a>
    <a href="manage_users.php">Manage Users</a>
    <a href="calendar.php">Calendar <span class="badge">17</span></a>
    <a href="login.php">Log Out</a>
</div>

<div class="container">
    <h1>User Management</h1>
    <!-- Table Content -->
    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Role</th>
            <th>Created At</th>
            <th>Action</th>
        </tr>
        <?php while ($user = $users->fetch_assoc()) { ?>
        <tr>
            <td><?= $user['id'] ?></td>
            <td><?= $user['username'] ?></td>
            <td><?= $user['role'] ?></td>
            <td><?= $user['created_at'] ?></td>
            <td>
                <a href="edit_user.php?id=<?= $user['id'] ?>">Edit</a> |
                <a href="delete_user.php?id=<?= $user['id'] ?>" onclick="return confirm('Bạn chắc chắn muốn xóa người dùng này?')">Delete</a>
            </td>
        </tr>
        <?php } ?>
    </table>
    <br>
    <a href="add_user.php">Add New User</a> <!-- Link to add new user -->
</div>
</body>
</html>
