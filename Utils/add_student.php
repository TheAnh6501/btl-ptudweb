<?php 
include "../connect.php";
session_start();
    if (!isset($_SESSION['user']) || $_SESSION['user'] == null) {
        header('Location: ../login.php');
        exit();
    }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $class_id = $_POST['class_id'];

    // Thêm học sinh vào database
    try {
        $stmt = $conn->prepare('INSERT INTO tb_student (name, gender, dob, class_id) VALUES (:name, :gender, :dob, :class_id)');
        $stmt->execute([
            'name' => $name,
            'gender' => $gender,
            'dob' => $dob,
            'class_id' => $class_id
        ]);

        // Quay lại trang student.php
        header("Location: ../student.php");
        exit();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        exit();
    }
}

// Fetch class list for the dropdown
$stmt = $conn->query('SELECT * FROM tb_class');
$classes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../CSS/index.css">
    <title>Thêm học sinh</title>
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
        <h2 class="text-2xl font-bold mb-4">Thêm học sinh</h2>
        <form action="add_student.php" method="post" class="max-w-md">
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Họ và tên</label>
                <input type="text" name="name" id="name" class="mt-1 p-2 block w-full border border-gray-300 rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="gender" class="block text-sm font-medium text-gray-700">Giới tính</label>
                <select name="gender" id="gender" class="mt-1 p-2 block w-full border border-gray-300 rounded-md" required>
                    <option value="Nam">Nam</option>
                    <option value="Nữ">Nữ</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="dob" class="block text-sm font-medium text-gray-700">Ngày sinh</label>
                <input type="date" name="dob" id="dob" class="mt-1 p-2 block w-full border border-gray-300 rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="class_id" class="block text-sm font-medium text-gray-700">Lớp</label>
                <select name="class_id" id="class_id" class="mt-1 p-2 block w-full border border-gray-300 rounded-md" required>
                    <?php foreach ($classes as $class): ?>
                        <option value="<?php echo $class['id']; ?>"><?php echo $class['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Thêm học sinh</button>
                <a href="../student.php" class="text-gray-600 hover:text-gray-900">Hủy</a>
            </div>
        </form>
    </div>
</body>
<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
</html>
