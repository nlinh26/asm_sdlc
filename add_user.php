<?php
include 'db.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Bạn không có quyền truy cập!");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Mã hóa mật khẩu

    $query = "INSERT INTO Users (name, email, role, password_hash) VALUES ('$name', '$email', '$role', '$password')";
    
    if ($conn->query($query) === TRUE) {
        echo "User added successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <link rel="stylesheet" href="bit.css">
</head>
<body>
<div class="container">
    <h1>Add New User</h1>
    <form method="POST">
        <label for="name">Full Name</label>
        <input type="text" name="name" id="name" required>

        <label for="email">Email</label>
        <input type="email" name="email" id="email" required>

        <label for="role">Role</label>
        <select name="role" id="role">
            <option value="admin">Admin</option>
            <option value="teacher">Teacher</option>
            <option value="student">Student</option>
        </select>

        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>

        <button type="submit">Add User</button>
    </form>
</div>
</body>
</html>
