<?php
session_start();
include 'db.php';

// Kiểm tra quyền Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("You do not have access!");
}

// Xử lý thêm lớp học
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $class_code = $_POST['class_code'];
    $class_name = $_POST['class_name'];
    $num_students = $_POST['num_students'];
    $subject_id = $_POST['subject_id'];  // Thêm trường subject_id từ form

    // Kiểm tra xem subject_id có tồn tại trong bảng Subjects không
    $check_subject_query = "SELECT id FROM Subjects WHERE id = ?";
    $stmt_check_subject = $conn->prepare($check_subject_query);
    $stmt_check_subject->bind_param("i", $subject_id);
    $stmt_check_subject->execute();
    $stmt_check_subject->store_result();

    if ($stmt_check_subject->num_rows === 0) {
        die("Mã môn học không hợp lệ!");
    }

    // Thêm lớp học vào cơ sở dữ liệu
    $query = "INSERT INTO Classes (class_code, class_name, num_students, subject_id) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssii", $class_code, $class_name, $num_students, $subject_id);

    if ($stmt->execute()) {
        echo "<script>alert('Lớp học đã được thêm thành công!'); window.location='class.php';</script>";
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
    <title>Add Class</title>
    <link rel="stylesheet" href="add_class.css">
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
        <h1>Add New Class</h1>

        <form method="POST">
            <label for="class_code">Class Code:</label>
            <input type="text" id="class_code" name="class_code" required>

            <label for="class_name">Class Name:</label>
            <input type="text" id="class_name" name="class_name" required>

            <label for="num_students">Number of Students:</label>
            <input type="number" id="num_students" name="num_students" min="1" required>

            <label for="subject_id">Subject:</label>
            <select name="subject_id" id="subject_id" required>
                <option value="">-- Select Subject --</option>
                <option value="1">Mathematics</option>
                <option value="2">Physics</option>
                <option value="3">Chemistry</option>
                <?php
                // Lấy danh sách môn học từ bảng Subjects
                $subjects = $conn->query("SELECT id, name FROM Subjects");
                while ($subject = $subjects->fetch_assoc()) {
                    echo "<option value='" . $subject['id'] . "'>" . htmlspecialchars($subject['name']) . "</option>";
                }
                ?>
            </select>

            <button type="submit">Add Class</button>
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
?>
