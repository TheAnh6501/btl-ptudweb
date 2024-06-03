<?php
include "../connect.php";
$error = '';
$success = '';
session_start();
    if (!isset($_SESSION['user']) || $_SESSION['user'] == null) {
        header('Location: ../login.php');
        exit();
    }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];

    if (empty($name)) {
        $error = 'Tên môn học không được để trống.';
    } else {
        $stmt = $conn->prepare('INSERT INTO tb_subject (name) VALUES (:name)');
        if ($stmt->execute(['name' => $name])) {
            $success = 'Môn học đã được thêm thành công.';
        } else {
            $error = 'Đã xảy ra lỗi. Vui lòng thử lại.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../CSS/index.css">
    <title>Thêm môn học</title>
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
                            <box-icon name='home-alt' class="icon"></box-icon>
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
                    <li class="nav-link">
                        <a href="../subject.php">
                            <box-icon name='book-alt' class="icon"></box-icon>
                            <span class="text nav-text">Quản lý môn học</span>
                        </a>
                    </li>
                    <div class="bottom-content">
                        <li class="nav-link">
                            <a href="../logout.php">
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
        <h2 class="text-2xl font-bold mb-4">Thêm môn học</h2>
        <form action="add_subject.php" method="post" class="border border-gray-300 rounded-md p-4">
            <?php if ($error != ''): ?>
                <p class="text-red-500"><?php echo $error; ?></p>
            <?php endif; ?>
            <?php if ($success != ''): ?>
                <p class="text-green-500"><?php echo $success; ?></p>
            <?php endif; ?>
            <div class="mb-4">
                <label for="name" class="block text-gray-700">Tên môn học:</label>
                <input type="text" name="name" id="name" class="border border-gray-300 rounded-md px-4 py-2 w-full">
            </div>
            <button type="submit" class="bg-green-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Thêm</button>
        </form>
    </div>
</body>
<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
</html>
