<?php
// Import file cấu hình database
include 'config/database.php';

if (isset($_GET['MaSV'])) {
    $sql = "SELECT * FROM SinhVien WHERE MaSV='{$_GET['MaSV']}'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
}

if (isset($_POST['update'])) {
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // Xử lý ảnh
    if (!empty($_FILES["Hinh"]["name"])) {
        $target_file = $target_dir . basename($_FILES["Hinh"]["name"]);
        move_uploaded_file($_FILES["Hinh"]["tmp_name"], $target_file);
    } else {
        $target_file = $row['Hinh']; // Giữ ảnh cũ nếu không chọn ảnh mới
    }

    $sql = "UPDATE SinhVien SET 
                HoTen='{$_POST['HoTen']}', 
                GioiTinh='{$_POST['GioiTinh']}', 
                NgaySinh='{$_POST['NgaySinh']}', 
                Hinh='$target_file', 
                MaNganh='{$_POST['MaNganh']}' 
            WHERE MaSV='{$_POST['MaSV']}'";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
        exit();
    } else {
        echo "Lỗi: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa Sinh viên</title>
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
        input[type="text"], input[type="date"], select, input[type="file"] {
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
        img {
            max-width: 100px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <h2>Chỉnh sửa Sinh Viên</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="MaSV" value="<?php echo $row['MaSV']; ?>">
        
        Họ Tên: <input type="text" name="HoTen" value="<?php echo $row['HoTen']; ?>" required><br>
        
        Giới Tính: 
        <select name="GioiTinh" required>
            <option value="Nam" <?php if ($row['GioiTinh'] == 'Nam') echo 'selected'; ?>>Nam</option>
            <option value="Nữ" <?php if ($row['GioiTinh'] == 'Nữ') echo 'selected'; ?>>Nữ</option>
        </select><br>

        Ngày Sinh: <input type="date" name="NgaySinh" value="<?php echo $row['NgaySinh']; ?>" required><br>
        
        <!-- Hiển thị ảnh hiện tại -->
        <?php if (!empty($row['Hinh'])) { ?>
            <img src="<?php echo $row['Hinh']; ?>" alt="Hình ảnh sinh viên">
        <?php } ?> 
        <br>
        
        Hình Ảnh: <input type="file" name="Hinh" accept="image/*"><br>
        
        <?php
        echo 'Ngành Học: <select name="MaNganh" required>';
        $sql = "SELECT MaNganh, TenNganh FROM NganhHoc";
        $result = $conn->query($sql);
        while ($nganh = $result->fetch_assoc()) {
            $selected = ($nganh['MaNganh'] == $row['MaNganh']) ? 'selected' : '';
            echo '<option value="' . $nganh['MaNganh'] . '" ' . $selected . '>' . $nganh['TenNganh'] . '</option>';
        }
        echo '</select><br>';
        ?>

        <input type="submit" name="update" value="Cập nhật">
    </form>
</body>
</html>
