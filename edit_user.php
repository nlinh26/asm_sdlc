<?php
include 'db.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Bạn không có quyền truy cập!");
}

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    $query = "SELECT * FROM Users WHERE user_id = $user_id";
    $result = $conn->query($query);
    $user = $result->fetch_assoc();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $role = $_POST['role'];

        $updateQuery = "UPDATE Users SET name = '$name', email = '$email', role = '$role' WHERE user_id = $user_id";

        if ($conn->query($updateQuery) === TRUE) {
            echo "User updated successfully!";
        } else {
            echo "Error: " . $conn->error;
        }
    }
} else {
    die("Invalid user ID.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="bit.css">
</head>
<body>
<div class="container">
    <h1>Edit User</h1>
    <form method="POST">
        <label for="name">Full Name</label>
        <input type="text" name="name" id="name" value="<?= $user['name'] ?>" required>

        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="<?= $user['email'] ?>" required>

        <label for="role">Role</label>
        <select name="role" id="role">
            <option value="admin" <?= ($user['role'] == 'admin') ? 'selected' : '' ?>>Admin</option>
            <option value="teacher" <?= ($user['role'] == 'teacher') ? 'selected' : '' ?>>Teacher</option>
            <option value="student" <?= ($user['role'] == 'student') ? 'selected' : '' ?>>Student</option>
        </select>

        <button type="submit">Update User</button>
    </form>
</div>
</body>
</html>
