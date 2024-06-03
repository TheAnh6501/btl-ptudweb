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

$stmt = $conn->prepare('DELETE FROM tb_teacher WHERE id = :id');
$stmt->execute(['id' => $teacher_id]);

header('Location: ../teacher.php');
exit;
?>
