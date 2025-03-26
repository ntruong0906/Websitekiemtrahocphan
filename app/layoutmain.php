<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ thống Quản lý</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
        }

        .navbar {
            background: #007bff;
            padding: 15px;
            text-align: center;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            margin: 0 10px;
            display: inline-block;
        }

        .navbar a:hover {
            background: #0056b3;
            border-radius: 5px;
        }

        .logout-btn {
            float: right;
            background: red;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
        }

        .logout-btn:hover {
            background: darkred;
        }

        .container {
            margin: 20px auto;
            width: 80%;
            background: white;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
    </style>
</head>

<body>

    <div class="navbar">
        <a href="layoutmain.php?page=index">Quản lý Sinh viên</a>
        <a href="layoutmain.php?page=QLHP">Quản lý Học phần</a>
    </div>

    <div class="container">
        <?php
        if (isset($_GET['page'])) {
            $page = $_GET['page'];
            if ($page == "index") {
                include 'index.php';
            } elseif ($page == "QLHP") {
                include 'QLHP.php';
            } else {
                echo "<h3>Trang không tồn tại!</h3>";
            }
        } else {
            echo "<h3>Chào mừng bạn đến với hệ thống quản lý!</h3>";
        }
        ?>
    </div>

</body>

</html>