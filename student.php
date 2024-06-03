<?php 
include"connect.php";
session_start();
    if (!isset($_SESSION['user']) || $_SESSION['user'] == null) {
        header('Location: login.php');
        exit();
    }
// Lấy danh sách các lớp
$stmt = $conn->query('SELECT * FROM tb_class');
$classes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Kiểm tra nếu có yêu cầu chọn lớp
if (isset($_GET['class_id'])) {
    $class_id = $_GET['class_id'];

    // Truy vấn danh sách học sinh trong lớp được chọn
    $stmt = $conn->prepare('SELECT * FROM tb_student WHERE class_id = :class_id');
    $stmt->execute(['class_id' => $class_id]);
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="./CSS/index.css">
    <title>Quản lý học sinh</title>
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
                            <box-icon name='home-alt' class="icon" ></box-icon>
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
        <!-- Dropdown button để chọn lớp -->
        <form action="" method="get" class="mb-4">
            <div class="flex items-center">
                <span class="mr-2">Chọn lớp:</span>
                <select name="class_id" onchange="this.form.submit()" class="border border-gray-300 rounded-md px-4 py-2">
                    <option value="">Select...</option>
                    <?php foreach ($classes as $class): ?>
                        <option value="<?php echo $class['id']; ?>" <?php if(isset($class_id) && $class_id == $class['id']) echo 'selected'; ?>><?php echo $class['name']; ?></option>
                    <?php endforeach; ?>
                </select>
                <a href="./Utils/add_student.php" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded ml-4">Thêm học sinh</a>
            </div>
        </form>
        
        <!-- Hiển thị danh sách học sinh -->
        <?php if (isset($students)): ?>
            <table class="w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border border-gray-300 px-4 py-2">Họ và tên</th>
                        <th class="border border-gray-300 px-4 py-2">Giới tính</th>
                        <th class="border border-gray-300 px-4 py-2">Ngày sinh</th>
                        <th class="border border-gray-300 px-4 py-2">Tùy chọn</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($students as $student): ?>
                        <tr class="">
                            <td class="border border-gray-300 px-4 py-2"><?php echo $student['name']; ?></td>
                            <td class="border border-gray-300 px-4 py-2 text-center"><?php echo $student['gender']; ?></td>
                            <td class="border border-gray-300 px-4 py-2 text-center"><?php echo $student['dob']; ?></td>
                            <td class="border border-gray-300 px-4 py-2 text-center">
                                <a href="Utils/edit_student.php?id=<?php echo $student['id']; ?>" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">Sửa thông tin</a>
                                <a href="Utils/delete_student.php?id=<?php echo $student['id']; ?>" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>

<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
</html>