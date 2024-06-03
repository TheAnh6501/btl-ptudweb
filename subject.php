<?php
include "connect.php";
session_start();
    if (!isset($_SESSION['user']) || $_SESSION['user'] == null) {
        header('Location: login.php');
        exit();
    }

$stmt = $conn->query('SELECT * FROM tb_class');
$classes = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $conn->query('SELECT * FROM tb_subject');
$subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);

$students_grades = [];

if (isset($_GET['class_id']) && isset($_GET['subject_id'])) {
    $class_id = $_GET['class_id'];
    $subject_id = $_GET['subject_id'];

    $stmt = $conn->prepare('
        SELECT tb_student.id AS student_id, tb_student.name AS student_name, tb_subject_grade.grade
        FROM tb_student
        LEFT JOIN tb_subject_grade ON tb_student.id = tb_subject_grade.student_id AND tb_subject_grade.subject_id = :subject_id
        WHERE tb_student.class_id = :class_id
    ');
    $stmt->execute(['class_id' => $class_id, 'subject_id' => $subject_id]);
    $students_grades = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="./CSS/index.css">
    <title>Quản lý môn học</title>
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
                            <box-icon name='home-alt' class="icon"></box-icon>
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
                        <a href="./teacher.php">
                            <box-icon type='solid' name='user-badge' class="icon"></box-icon>
                            <span class="text nav-text">Quản lý giáo viên</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="./classroom.php">
                            <box-icon type='solid' name='school' class="icon"></box-icon>
                            <span class="text nav-text">Quản lý lớp học</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="./subject.php">
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
        <h2 class="text-2xl font-bold mb-4">Quản lý môn học</h2>
        <a href="./Utils/add_subject.php" class="bg-green-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">Thêm môn học</a>
        
        <form action="" method="get" class="mb-4">
            <div class="flex items-center mb-4">
                <span class="mr-2">Chọn lớp:</span>
                <select name="class_id" onchange="this.form.submit()" class="border border-gray-300 rounded-md px-4 py-2">
                    <option value="">Select...</option>
                    <?php foreach ($classes as $class): ?>
                        <option value="<?php echo $class['id']; ?>" <?php if(isset($_GET['class_id']) && $_GET['class_id'] == $class['id']) echo 'selected'; ?>><?php echo $class['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="flex items-center">
                <span class="mr-2">Chọn môn học:</span>
                <select name="subject_id" onchange="this.form.submit()" class="border border-gray-300 rounded-md px-4 py-2">
                    <option value="">Select...</option>
                    <?php foreach ($subjects as $subject): ?>
                        <option value="<?php echo $subject['id']; ?>" <?php if(isset($_GET['subject_id']) && $_GET['subject_id'] == $subject['id']) echo 'selected'; ?>><?php echo $subject['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </form>

        <?php if (!empty($students_grades)): ?>
            <table class="w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border border-gray-300 px-4 py-2">Họ và tên</th>
                        <th class="border border-gray-300 px-4 py-2">Điểm số</th>
                        <th class="border border-gray-300 px-4 py-2">Tùy chọn</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($students_grades as $student_grade): ?>
                        <tr>
                            <td class="border border-gray-300 px-4 py-2"><?php echo $student_grade['student_name']; ?></td>
                            <td class="border border-gray-300 px-4 py-2 text-center"><?php echo $student_grade['grade']; ?></td>
                            <td class="border border-gray-300 px-4 py-2 text-center">
                                <a href="Utils/edit_grade.php?student_id=<?php echo $student_grade['student_id']; ?>&subject_id=<?php echo $subject_id; ?>" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">Sửa thông tin</a>
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
