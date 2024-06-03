<?php
include "../connect.php";
session_start();
    if (!isset($_SESSION['user']) || $_SESSION['user'] == null) {
        header('Location: ../login.php');
        exit();
    }
$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $grade_id = isset($_GET['id']) ? $_GET['id'] : null;
    $student_id = isset($_GET['student_id']) ? $_GET['student_id'] : null;
    $subject_id = isset($_GET['subject_id']) ? $_GET['subject_id'] : null;
    $class_id = isset($_GET['class_id']) ? $_GET['class_id'] : null;

    if ($grade_id) {

        $stmt = $conn->prepare('SELECT * FROM tb_subject_grade WHERE id = :id');
        $stmt->execute(['id' => $grade_id]);
        $grade = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($grade) {
            $student_id = $grade['student_id'];
            $subject_id = $grade['subject_id'];
            $grade_value = $grade['grade'];
        } else {
            $error = 'Grade not found.';
        }
    }

    if (!$grade_id && ($student_id && $subject_id)) {
        // Check if a grade already exists
        $stmt = $conn->prepare('SELECT * FROM tb_subject_grade WHERE student_id = :student_id AND subject_id = :subject_id');
        $stmt->execute(['student_id' => $student_id, 'subject_id' => $subject_id]);
        $grade = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($grade) {
            $grade_id = $grade['id'];
            $grade_value = $grade['grade'];
        } else {
            $grade_value = null;
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $grade_id = isset($_POST['grade_id']) ? $_POST['grade_id'] : null;
    $student_id = $_POST['student_id'];
    $subject_id = $_POST['subject_id'];
    $class_id = $_POST['class_id'];
    $grade_value = $_POST['grade'];

    if ($grade_id) {
 
        $stmt = $conn->prepare('UPDATE tb_subject_grade SET grade = :grade WHERE id = :id');
        $success = $stmt->execute(['grade' => $grade_value, 'id' => $grade_id]);
    } else {

        $stmt = $conn->prepare('INSERT INTO tb_subject_grade (student_id, subject_id, grade) VALUES (:student_id, :subject_id, :grade)');
        $success = $stmt->execute(['student_id' => $student_id, 'subject_id' => $subject_id, 'grade' => $grade_value]);
    }

    if ($success) {
        header('Location: ../subject.php?class_id=' . $class_id . '&subject_id=' . $subject_id);
        exit;
    } else {
        $error = 'Failed to save the grade.';
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
    <title>Edit Grade</title>
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
        <div class="container mx-auto mt-8">
            <h2 class="text-2xl font-bold mb-4">Sửa điểm</h2>
            <?php if ($error): ?>
                <p class="text-red-500"><?php echo $error; ?></p>
            <?php endif; ?>
            <form action="edit_grade.php" method="post">
                <input type="hidden" name="grade_id" value="<?php echo $grade_id; ?>">
                <input type="hidden" name="student_id" value="<?php echo $student_id; ?>">
                <input type="hidden" name="subject_id" value="<?php echo $subject_id; ?>">
                <input type="hidden" name="class_id" value="<?php echo $class_id; ?>">
                <div class="mb-4">
                    <label class="block text-gray-700">Điểm</label>
                    <input type="number" step="0.01" name="grade" value="<?php echo $grade_value; ?>" class="border border-gray-300 rounded-md px-4 py-2 w-full">
                </div>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Lưu</button>
            </form>
        </div>
    </div>
</body>
<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
</html>
