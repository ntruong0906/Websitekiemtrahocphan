<?php
// Import file cấu hình database
include 'config/database.php';
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Sinh viên</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
        }
        form {
            background: white;
            width: 50%;
            margin: 20px auto;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        input[type="text"], input[type="date"], input[type="password"], select, input[type="file"] {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
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
    </style>
</head>

<body>
    <h2>Thêm Sinh Viên</h2>
    <form action="create.php" method="POST" enctype="multipart/form-data">
        Mã SV: <input type="text" name="MaSV" required><br>
        Họ Tên: <input type="text" name="HoTen" required><br>
        Giới Tính: 
        <select name="GioiTinh" required>
            <option value="Nam">Nam</option>
            <option value="Nữ">Nữ</option>
        </select><br>
        Ngày Sinh: <input type="date" name="NgaySinh" required><br>
        Mật khẩu: <input type="password" name="password" required><br>
        Hình Ảnh: <input type="file" name="Hinh"><br>
        <?php
        echo 'Ngành Học: <select name="MaNganh" required>';
        $sql = "SELECT MaNganh, TenNganh FROM NganhHoc";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            echo '<option value="' . $row['MaNganh'] . '">' . $row['TenNganh'] . '</option>';
        }
        echo '</select><br>';
        ?>
        <input type="submit" name="submit" value="Thêm">
    </form>

    <?php
    if (isset($_POST['submit'])) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        if (!empty($_FILES["Hinh"]["name"])) {
            $target_file = $target_dir . basename($_FILES["Hinh"]["name"]);
            move_uploaded_file($_FILES["Hinh"]["tmp_name"], $target_file);
        } else {
            $target_file = "";
        }

        // Kiểm tra Mã SV có bị trùng không
        $check_masv = "SELECT MaSV FROM SinhVien WHERE MaSV = '{$_POST['MaSV']}'";
        $result_masv = $conn->query($check_masv);
        if ($result_masv->num_rows > 0) {
            die("<p style='color:red;'>Lỗi: Mã SV đã tồn tại! Vui lòng nhập Mã SV khác.</p>");
        }

        // Mã hóa mật khẩu trước khi lưu vào database
        $password_hashed = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO SinhVien (MaSV, HoTen, GioiTinh, NgaySinh, Hinh, MaNganh, password) VALUES
                ('{$_POST['MaSV']}', '{$_POST['HoTen']}', '{$_POST['GioiTinh']}', '{$_POST['NgaySinh']}', '$target_file', '{$_POST['MaNganh']}', '$password_hashed')";

        if ($conn->query($sql) === TRUE) {
            echo "<p style='color:green;'>Thêm thành công! <a href='index.php'>Quay lại</a></p>";
        } else {
            echo "<p style='color:red;'>Lỗi: " . $conn->error . "</p>";
        }
    }
    ?>
</body>

</html>
