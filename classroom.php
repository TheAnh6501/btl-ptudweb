<?php
include "connect.php";
session_start();
    if (!isset($_SESSION['user']) || $_SESSION['user'] == null) {
        header('Location: login.php');
        exit();
    }

$stmt = $conn->query('SELECT c.id AS class_id, c.name AS class_name, t.id AS teacher_id, t.name AS teacher_name FROM tb_class c LEFT JOIN tb_teacher t ON c.teacher_id = t.id');
$classes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="./CSS/index.css">
    <title>Quản lý lớp học</title>
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
                        <a href="index.php">
                            <box-icon name='home-alt' class="icon"></box-icon>
                            <span class="text nav-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="student.php">
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
        <h2 class="text-2xl font-bold mb-4">Thông tin lớp học và giáo viên chủ nhiệm</h2>
        <a href="./Utils/add_class.php" class="bg-green-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">Thêm lớp học</a>
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border border-gray-300 px-4 py-2">ID</th>
                    <th class="border border-gray-300 px-4 py-2">Tên lớp học</th>
                    <th class="border border-gray-300 px-4 py-2">Giáo viên chủ nhiệm</th>
                    <th class="border border-gray-300 px-4 py-2">Tùy chọn</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($classes as $class): ?>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2 text-center"><?php echo $class['class_id']; ?></td>
                        <td class="border border-gray-300 px-4 py-2 text-center"><?php echo $class['class_name']; ?></td>
                        <td class="border border-gray-300 px-4 py-2 text-center">
                            <?php echo ($class['teacher_name']) ? $class['teacher_name'] : "Chưa có"; ?>
                        </td>
                        <td class="border border-gray-300 px-4 py-2 text-center">
                            <a href="Utils/edit_class.php?id=<?php echo $class['class_id']; ?>" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">Sửa thông tin</a>
                            <a href="Utils/delete_class.php?id=<?php echo $class['class_id']; ?>" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded ml-2">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
</html>
