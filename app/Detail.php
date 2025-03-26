<?php
// Import file cấu hình database
include 'config/database.php';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết Sinh Viên</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
        }
        .container {
            background: white;
            width: 50%;
            margin: 20px auto;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: left;
            border-radius: 10px;
        }
        img {
            max-width: 150px;
            border-radius: 5px;
            margin-top: 10px;
        }
        .back-btn {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 15px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .back-btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

<?php
if (isset($_GET['MaSV'])) {
    $sql = "SELECT * FROM SinhVien WHERE MaSV='{$_GET['MaSV']}'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    if ($row) {
        echo "<div class='container'>
                <h2>Chi tiết Sinh Viên</h2>
                <p><strong>Mã SV:</strong> {$row['MaSV']}</p>
                <p><strong>Họ Tên:</strong> {$row['HoTen']}</p>
                <p><strong>Giới Tính:</strong> {$row['GioiTinh']}</p>
                <p><strong>Ngày Sinh:</strong> {$row['NgaySinh']}</p>
                <p><strong>Ảnh:</strong><br> 
                   <img src='{$row['Hinh']}' alt='Hình ảnh sinh viên'></p>
                <p><strong>Ngành Học:</strong> {$row['MaNganh']}</p>
                <a href='index.php' class='back-btn'>Quay lại</a>
              </div>";
    } else {
        echo "<p>Không tìm thấy sinh viên!</p>";
    }
} else {
    echo "<p>Thiếu thông tin sinh viên!</p>";
}
?>

</body>
</html>
