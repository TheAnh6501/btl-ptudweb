<?php 
include "../connect.php";
session_start();
    if (!isset($_SESSION['user']) || $_SESSION['user'] == null) {
        header('Location: ../login.php');
        exit();
    }

// Kiểm tra id
if (isset($_GET['id'])) {
    $student_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    // Xóa khỏi database
    try {
        $stmt = $conn->prepare('DELETE FROM tb_student WHERE id = :id');
        $stmt->execute(['id' => $student_id]);

        // Quay về trang student.php
        header("Location: ../student.php");
        exit();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }
} else {
    echo "No student ID provided!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../CSS/index.css">
    
    <title>Sửa thông tin học sinh</title>
</head>
<body>
    <nav class="sidebar">
        <header>
            <div class="image-text">
                <span class="image">
                    <img src="../Assests/logo.png" alt="logo">
                </span>

                <div class="text header-text">
                    <span class="name">Xin chào, Admin</span>
                </div>
            </div>
        </header>

        <div class="menu-bar">
            <div class="menu">
                <ul class="menu-links">
                    <li class="nav-link">
                        <a href="../index.php">
                            <box-icon name='home-alt' class="icon" ></box-icon>
                            <span class="text nav-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="../student.php">
                            <box-icon name='user' class="icon"></box-icon>
                            <span class="text nav-text">Quản lý học sinh</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="../teacher.php">
                            <box-icon type='solid' name='user-badge' class="icon"></box-icon>
                            <span class="text nav-text">Quản lý giáo viên</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="../classroom.php">
                            <box-icon type='solid' name='school' class="icon"></box-icon>
                            <span class="text nav-text">Quản lý lớp học</span>
                        </a>
                    </li>
                    <div class="bottom-content">
                        <li class="nav-link">
                            <a href="#">
                                <box-icon name='log-out' class="icon"></box-icon>
                                <span class="text nav-text">Đăng xuất</span>
                            </a>
                        </li>
                    </div>
                </ul>
            </div>
        </div>
    </nav>
    <div class="right">
    </div>
</body>
<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
</html>