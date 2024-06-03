<?php
include "connect.php";
session_start();
    if (!isset($_SESSION['user']) || $_SESSION['user'] == null) {
        header('Location: login.php');
        exit();
    };
$stmt = $conn->query('SELECT COUNT(*) AS total_students FROM tb_student');
$total_students = $stmt->fetch(PDO::FETCH_ASSOC)['total_students'];

$stmt = $conn->query('SELECT COUNT(*) AS total_teachers FROM tb_teacher');
$total_teachers = $stmt->fetch(PDO::FETCH_ASSOC)['total_teachers'];

$stmt = $conn->query('SELECT COUNT(*) AS total_classes FROM tb_class');
$total_classes = $stmt->fetch(PDO::FETCH_ASSOC)['total_classes'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="./CSS/index.css">
    
    <title>Dashboard</title>
</head>
<body>
    <nav class="sidebar">
        <header>
            <div class="image-text">
                <span class="image">
                    <img src="./Assests/logo.png" alt="logo">
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
                        <a href="./index.php">
                            <box-icon name='home-alt' class="icon" ></box-icon>
                            <span class="text nav-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="./student.php">
                            <box-icon name='user' class="icon"></box-icon>
                            <span class="text nav-text">Quản lý học sinh</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="teacher.php">
                            <box-icon type='solid' name='user-badge' class="icon"></box-icon>
                            <span class="text nav-text">Quản lý giáo viên</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="classroom.php">
                            <box-icon type='solid' name='school' class="icon"></box-icon>
                            <span class="text nav-text">Quản lý lớp học</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="subject.php">
                            <box-icon name='book-alt' class="icon"></box-icon>
                            <span class="text nav-text">Quản lý môn học</span>
                        </a>
                    </li>
                    <div class="bottom-content">
                        <li class="nav-link">
                            <a href="logout.php">
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
        <div class="right-side-box">
            <div>
                <h3 class="font-bold">Tổng số học sinh</h3>
                <p><?php echo $total_students; ?></p>
            </div>
            <div>
                <h3 class="font-bold">Tổng số giáo viên</h3>
                <p><?php echo $total_teachers; ?></p>
            </div>
            <div>
                <h3 class="font-bold">Tổng số lớp học</h3>
                <p><?php echo $total_classes; ?></p>
            </div>
        </div>
    </div>
</body>
<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
</html>