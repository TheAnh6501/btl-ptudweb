<?php
include "../connect.php";
session_start();
    if (!isset($_SESSION['user']) || $_SESSION['user'] == null) {
        header('Location: ../login.php');
        exit();
    }

if (!isset($_GET['id'])) {
    header('Location: ../classroom.php');
    exit;
}

$class_id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $class_name = $_POST['class_name'];
    $teacher_id = $_POST['teacher_id'];

    $stmt = $conn->prepare('UPDATE tb_class SET name = :name, teacher_id = :teacher_id WHERE id = :id');
    $stmt->execute(['name' => $class_name, 'teacher_id' => $teacher_id, 'id' => $class_id]);

    header('Location: ../classroom.php');
    exit;
}

$stmt = $conn->prepare('SELECT * FROM tb_class WHERE id = :id');
$stmt->execute(['id' => $class_id]);
$class = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $conn->query('SELECT * FROM tb_teacher');
$teachers = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../CSS/index.css">
    <title>Sửa lớp học</title>
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
        <h2 class="text-2xl font-bold mb-4">Sửa lớp học</h2>
        <form action="" method="post" class="max-w-md">
            <div class="mb-4">
                <label for="class_name" class="block text-sm font-medium text-gray-700">Tên lớp học</label>
                <input type="text" name="class_name" id="class_name" class="mt-1 p-2 block w-full border border-gray-300 rounded-md" value="<?php echo htmlspecialchars($class['name']); ?>" required>
            </div>
            <div class="mb-4">
                <label for="teacher_id" class="block text-sm font-medium text-gray-700">Giáo viên chủ nhiệm</label>
                <select name="teacher_id" id="teacher_id" class="mt-1 p-2 block w-full border border-gray-300 rounded-md" required>
                    <option value="">Chọn giáo viên</option>
                    <?php foreach ($teachers as $teacher): ?>
                        <option value="<?php echo $teacher['id']; ?>" <?php if ($teacher['id'] == $class['teacher_id']) echo 'selected'; ?>><?php echo htmlspecialchars($teacher['name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Cập nhật</button>
                <a href="../classroom.php" class="text-gray-600 hover:text-gray-900">Hủy</a>
            </div>
        </form>
    </div>
</body>

<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
</html>
