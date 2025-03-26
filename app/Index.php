<?php
// Import file cấu hình database
include 'config/database.php';
?>

<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Sinh viên</title>
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

        th,
        td {
            border: 1px solid black;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        a {
            text-decoration: none;
            color: white;
            background: #28a745;
            padding: 8px 12px;
            margin: 5px;
            border-radius: 5px;
            display: inline-block;
        }

        a:hover {
            background: #218838;
        }

        .delete {
            background: #dc3545;
        }

        .delete:hover {
            background: #c82333;
        }

        .add-btn {
            display: inline-block;
            background: #007bff;
            padding: 10px 15px;
            color: white;
            border-radius: 5px;
            margin: 20px auto;
        }

        .add-btn:hover {
            background: #0056b3;
        }
    </style>
</head>

<body>
    <h2>Danh sách Sinh viên</h2>
    <table>
        <tr>
            <th>Mã SV</th>
            <th>Họ Tên</th>
            <th>Giới Tính</th>
            <th>Ngày Sinh</th>
            <th>Hình Ảnh</th>
            <th>Ngành Học</th>
            <th>Hành Động</th>
        </tr>
        <?php
        $sql = "SELECT * FROM SinhVien";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>{$row['MaSV']}</td>
                    <td>{$row['HoTen']}</td>
                    <td>{$row['GioiTinh']}</td>
                    <td>{$row['NgaySinh']}</td>
                    <td><img src='{$row['Hinh']}' width='50'></td>
                    <td>{$row['MaNganh']}</td>
                    <td>
                        <a href='edit.php?MaSV={$row['MaSV']}'>Sửa</a> |
                        <a href='delete.php?MaSV={$row['MaSV']}' class='delete' onclick='return confirm(\"Bạn có chắc muốn xóa?\")'>Xóa</a> |
                        <a href='detail.php?MaSV={$row['MaSV']}'>Chi tiết</a>
                    </td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>Không có sinh viên nào</td></tr>";
        }
        ?>
    </table>
    <a href="create.php" class="add-btn">Thêm Sinh Viên</a>

    <?php $conn->close(); ?>
</body>

</html>