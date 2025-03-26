<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['MaSV'])) {
    header("Location: login.php");
    exit();
}
$MaSV = $_SESSION['MaSV'];


include 'config/database.php';

$MaSV = $_SESSION['MaSV'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['hocphan'])) {
    $sql_dangky = "INSERT INTO DangKy (NgayDK, MaSV) VALUES (NOW(), '$MaSV')";
    if ($conn->query($sql_dangky) === TRUE) {
        $MaDK = $conn->insert_id;
        foreach ($_POST['hocphan'] as $MaHP) {
            $sql_chitiet = "INSERT INTO ChiTietDangKy (MaDK, MaHP) VALUES ('$MaDK', '$MaHP')";
            $conn->query($sql_chitiet);
        }
        echo "<p style='color: green; text-align: center;'>Đăng ký thành công!</p>";
    } else {
        echo "<p style='color: red; text-align: center;'>Lỗi: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký Học Phần</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
        }
        .container {
            background: white;
            width: 60%;
            margin: 20px auto;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }
        th {
            background: #007bff;
            color: white;
        }
        input[type="submit"] {
            background: #28a745;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
        input[type="submit"]:hover {
            background: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Danh Sách Học Phần</h2>
        <form method="POST">
            <table>
                <tr>
                    <th>Chọn</th>
                    <th>Mã HP</th>
                    <th>Tên Học Phần</th>
                    <th>Số Tín Chỉ</th>
                </tr>
                <?php
                $sql = "SELECT * FROM HocPhan";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td><input type='checkbox' name='hocphan[]' value='{$row['MaHP']}'></td>
                            <td>{$row['MaHP']}</td>
                            <td>{$row['TenHP']}</td>
                            <td>{$row['SoTinChi']}</td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>Không có học phần nào</td></tr>";
                }
                ?>
            </table>
            <input type="submit" value="Đăng Ký">
        </form>
        <a href="QLHP.php">Quay lại</a>
    </div>
</body>
</html>
