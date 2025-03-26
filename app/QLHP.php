<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['MaSV'])) {
    header("Location: login.php");
    exit();
}

include 'config/database.php';

$MaSV = $_SESSION['MaSV']; // Lấy MaSV từ session

// Xử lý hủy đăng ký học phần
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_hp'])) {
    $MaHP = $_POST['MaHP'];

    // Xóa học phần khỏi bảng ChiTietDangKy
    $sql_delete = "DELETE ChiTietDangKy FROM ChiTietDangKy 
                   JOIN DangKy ON ChiTietDangKy.MaDK = DangKy.MaDK
                   WHERE DangKy.MaSV = '$MaSV' AND ChiTietDangKy.MaHP = '$MaHP'";
    if ($conn->query($sql_delete) === TRUE) {
        echo "<p style='color: green; text-align: center;'>Đã hủy học phần thành công!</p>";
    } else {
        echo "<p style='color: red; text-align: center;'>Lỗi: " . $conn->error . "</p>";
    }
}

// Lấy danh sách môn học mà sinh viên đã đăng ký
$sql = "SELECT HocPhan.MaHP, HocPhan.TenHP, HocPhan.SoTinChi 
        FROM HocPhan 
        JOIN ChiTietDangKy ON HocPhan.MaHP = ChiTietDangKy.MaHP 
        JOIN DangKy ON ChiTietDangKy.MaDK = DangKy.MaDK
        WHERE DangKy.MaSV = '$MaSV'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Học Phần</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
        }
        h2 {
            color: #333;
        }
        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
            background: white;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        th, td {
            border: 1px solid black;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        .btn {
            text-decoration: none;
            color: white;
            background: #28a745;
            padding: 8px 12px;
            margin: 5px;
            border-radius: 5px;
            display: inline-block;
        }
        .btn:hover {
            background: #218838;
        }
        .delete-btn {
            background: #dc3545;
        }
        .delete-btn:hover {
            background: #c82333;
        }
        .logout-btn {
            position: absolute;
            top: 10px;
            right: 20px;
            background: red;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
        }
        .logout-btn:hover {
            background: darkred;
        }

        .home-btn {
            position: absolute;
            top: 10px;
            left: 20px;
            background: #007bff;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
        }
        .home-btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>


<a href="layoutmain.php" class="home-btn">Trang chủ</a>
<a href="logout.php" class="logout-btn">Đăng xuất</a>

<h2>Danh Sách Học Phần Đã Đăng Ký</h2>
<table>
    <tr>
        <th>Mã HP</th>
        <th>Tên Học Phần</th>
        <th>Số Tín Chỉ</th>
        <th>Hành Động</th>
    </tr>
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>{$row['MaHP']}</td>
                <td>{$row['TenHP']}</td>
                <td>{$row['SoTinChi']}</td>
                <td>
                    <form method='POST' style='display:inline;'>
                        <input type='hidden' name='MaHP' value='{$row['MaHP']}'>
                        <input type='submit' name='delete_hp' value='Xóa' class='btn delete-btn' onclick='return confirm(\"Bạn có chắc muốn hủy học phần này?\")'>
                    </form>
                </td>
            </tr>";
        }
    } else {
        echo "<tr><td colspan='4'>Bạn chưa đăng ký học phần nào</td></tr>";
    }
    ?>
</table>

<a href="register.php" class="btn">Đăng Ký Học Phần</a>

</body>
</html>
