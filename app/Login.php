<?php
// Import file cấu hình database
include 'config/database.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $MaSV = $_POST['MaSV'];
    $password = $_POST['password'];

    // Kiểm tra sinh viên có tồn tại không
    $sql = "SELECT * FROM SinhVien WHERE MaSV = '$MaSV'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) { // Kiểm tra mật khẩu
            $_SESSION['MaSV'] = $MaSV;
            header("Location: QLHP.php");
            exit();
        } else {
            $error = "Sai Mã SV hoặc mật khẩu!";
        }
    } else {
        $error = "Sai Mã SV hoặc mật khẩu!";
    }

}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
        }

        .container {
            background: white;
            width: 30%;
            margin: 100px auto;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 8px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            background: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .error {
            color: red;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Đăng Nhập</h2>
        <?php if (isset($error))
            echo "<p class='error'>$error</p>"; ?>
        <form method="POST">
            Mã SV: <input type="text" name="MaSV" required><br>
            Mật khẩu: <input type="password" name="password" required><br>
            <input type="submit" value="Đăng Nhập">
        </form>
    </div>
</body>

</html>