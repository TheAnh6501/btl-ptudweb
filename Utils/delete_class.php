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

$stmt = $conn->prepare('DELETE FROM tb_class WHERE id = :id');
$stmt->execute(['id' => $class_id]);

header('Location: ../classroom.php');
exit;
?>
