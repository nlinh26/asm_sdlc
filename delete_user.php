<?php
include 'db.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Bạn không có quyền truy cập!");
}

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    $deleteQuery = "DELETE FROM Users WHERE user_id = $user_id";

    if ($conn->query($deleteQuery) === TRUE) {
        echo "User deleted successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    die("Invalid user ID.");
}
?>
