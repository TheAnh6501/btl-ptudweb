<?php
session_start();
include"connect.php";
$error = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['passwordd'];
    $sql = "SELECT username, passwordd, typee FROM account WHERE username = '$username'";
    $stmt = $conn->prepare($sql);
    $query = $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result) {
        $userreal = $result['username'];
        $passreal = $result['passwordd'];
        $type = $result['typee'];
        if ($username == $userreal && $password == $passreal) {
            if($type == 0){
                $_SESSION['user'] = 'admin';
                header('Location: index.php');
                exit;
            }else{
                // $_SESSION['user'] = 'user';
                // header('Location: user.php');
                exit;
            }
        } else {
            $error = 'Tên đăng nhập hoặc mật khẩu không chính xác.';
        }
    }else{
        $error = 'Tên đăng nhập hoặc mật khẩu không chính xác.';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        *{
            margin: auto;
        }
        h3{
            margin-top: 10%;
        }

        .dn{
            text-align: right;
            margin-top: 20px;
        }
        form{
            justify-content: center;
            width: 500px;
            border: 1px solid gainsboro;
            padding: 20px;
            margin-top: 10%;
        }
    </style>
</head>
<body>
    <div class="container">
        <h3 class="text-center">Phần mềm quản lý học sinh</h3>
        <form action="login.php" method="post">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username">
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" id="passwordd" name="passwordd">
            </div>
            <div class="dn">
                <button type="submit" class="btn btn-primary">Đăng nhập</button>
            </div>
        </form>
        
        <?php
        if ($error != '') {
            echo '<p style="color:red;">'.$error.'</p>';
        }
        ?>


    </div>

    
</body>
</html>

