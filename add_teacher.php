<?php
include 'db.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Bạn không có quyền truy cập!");
}

// Lấy thông tin từ form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Kiểm tra sự tồn tại của các chỉ mục trong $_POST
    $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';
    $full_name = isset($_POST['full_name']) ? $_POST['full_name'] : '';
    $department = isset($_POST['department']) ? $_POST['department'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $phone_number = isset($_POST['phone_number']) ? $_POST['phone_number'] : '';

    // Kiểm tra các trường bắt buộc có dữ liệu
    if (empty($user_id) || empty($full_name) || empty($email) || empty($phone_number)) {
        die("Vui lòng điền đầy đủ thông tin!");
    }

    // Kiểm tra user_id có tồn tại trong bảng users không
    $check_user_query = "SELECT id FROM users WHERE id = ?";
    $stmt = $conn->prepare($check_user_query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        die("User ID không tồn tại trong bảng users!");
    }

    // Thêm giáo viên vào bảng teachers
    $query = "INSERT INTO teachers (id, full_name, department, email, phone_number) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("issss", $id, $full_name, $department, $email, $phone_number);

    if ($stmt->execute()) {
        echo "Thêm giáo viên thành công!";
    } else {
        echo "Lỗi: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Teacher</title>
    <link rel="stylesheet" href="add_teacher.css"> <!-- Bạn có thể thêm CSS cho giao diện -->
</head>
<body>
    <div class="sidebar">
        <h3>Hello Admin</h3>
        <a href="admin.php">Home</a>
        <a href="class.php">Class</a>
        <a href="add_teacher.php">Add Teacher</a>
        <a href="criteria.php">Manage evaluation criteria</a>
        <a href="evaluate.php">Internal review management</a>
        <a href="calendar.php">Calendar <span class="badge">17</span></a>
        <a href="login.php">Log Out</a>
    </div>

    <div class="container">
        <h1>Add New Teacher</h1>
        <form method="POST" action="add_teacher.php">
    <label for="user_id">User ID:</label>
    <input type="text" name="user_id" id="user_id" required><br><br>

    <label for="full_name">Full Name:</label>
    <input type="text" name="full_name" id="full_name" required><br><br>

    <label for="department">Department:</label>
    <input type="text" name="department" id="department"><br><br>

    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required><br><br>

    <label for="phone_number">Phone Number:</label>
    <input type="text" name="phone_number" id="phone_number" required><br><br>

    <button type="submit">Add Teacher</button>
</form>
    </div>
</body>
</html>
