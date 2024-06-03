<?php
include "../connect.php";
session_start();
    if (!isset($_SESSION['user']) || $_SESSION['user'] == null) {
        header('Location: ../login.php');
        exit();
    }

if (!isset($_GET['id'])) {
    header('Location: ../teacher.php');
    exit;
}

$teacher_id = $_GET['id'];

$stmt = $conn->prepare('SELECT * FROM tb_teacher WHERE id = :id');
$stmt->execute(['id' => $teacher_id]);
$teacher = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$teacher) {

    header('Location: ../teacher.php');
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Update teacher information in the database
    $stmt = $conn->prepare('UPDATE tb_teacher SET name = :name, gender = :gender, email = :email, phone = :phone WHERE id = :id');
    $stmt->execute(['name' => $name, 'gender' => $gender, 'email' => $email, 'phone' => $phone, 'id' => $teacher_id]);

    // Redirect to teacher management page after update
    header('Location: ../teacher.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../CSS/index.css">
    <title>Sửa thông tin giáo viên</title>
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
        <h2 class="text-2xl font-bold mb-4">Sửa thông tin giáo viên</h2>
        <form action="edit_teacher.php?id=<?php echo $teacher_id; ?>" method="post" class="max-w-md">
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Họ và tên</label>
                <input type="text" name="name" id="name" value="<?php echo $teacher['name']; ?>" class="mt-1 p-2 block w-full border border-gray-300 rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="gender" class="block text-sm font-medium text-gray-700">Giới tính</label>
                <select name="gender" id="gender" class="mt-1 p-2 block w-full border border-gray-300 rounded-md" required>
                    <option value="Nam" <?php if ($teacher['gender'] === 'Nam') echo 'selected'; ?>>Nam</option>
                    <option value="Nữ" <?php if ($teacher['gender'] === 'Nữ') echo 'selected'; ?>>Nữ</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" value="<?php echo $teacher['email']; ?>" class="mt-1 p-2 block w-full border border-gray-300 rounded-md" required>
            </div>
            <div class="mb-4">
                <label for="phone" class="block text-sm font-medium text-gray-700">Số điện thoại</label>
                <input type="text" name="phone" id="phone" value="<?php echo $teacher['phone']; ?>" class="mt-1 p-2 block w-full border border-gray-300 rounded-md" required>
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Lưu thay đổi</button>
                <a href="../teacher.php" class="text-gray-600 hover:text-gray-900">Hủy</a>
            </div>
        </form>
    </div>
</body>

<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
</html>
