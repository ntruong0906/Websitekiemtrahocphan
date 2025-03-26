<?php
// Import file cấu hình database
include 'config/database.php';
?>
<?php
if (isset($_GET['MaSV'])) {
    $sql = "DELETE FROM SinhVien WHERE MaSV='{$_GET['MaSV']}'";
    $conn->query($sql);
    header("Location: index.php");
}
?>