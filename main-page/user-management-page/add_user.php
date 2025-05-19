<?php
if (session_status() == PHP_SESSION_NONE) session_start();
include '../../login/connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['FullName'];
    $email = $_POST['Email'];
    $password = $_POST['Password'];
    $phone = $_POST['PhoneNumber'];
    $address = $_POST['Address'];

    // hash password
    $hashedPassword = hash('sha256', $password);

    $sql = "{CALL sp_AddCustomer(?, ?, ?, ?, ?)}";
    $params = array($name, $email, $hashedPassword, $phone, $address);

    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    header('Location: user_management.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm người dùng</title>
    <link rel="stylesheet" href="../style/style_index.css">
    <style>
        .form-container {
            flex-grow: 1;
            padding: 30px;
        }

        form {
            background-color: white;
            padding: 30px;
            max-width: 600px;
            margin: 0 auto;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        form h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #3498db;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #2ecc71;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
        }

        button:hover {
            background-color: #27ae60;
        }
    </style>
</head>
<body>
    <aside class="sidebar">
        <h2>Admin</h2>
        <a href="../home-page/home.php">Trang chủ</a>
        <a href="../user-management-page/user_management.php">Quản lý người dùng</a>
        <a href="../order-management-page/order_management.php">Quản lý đơn hàng</a>
        <a href="../product-management-page/product_management.php">Quản lý sản phẩm</a>
        <a href="../../login/login.php">Đăng xuất</a>
    </aside>

    <div class="main-content">
        <header class="header">
            <h1>Thêm người dùng mới</h1>
        </header>

        <div class="form-container">
            <form method="POST">
                <h2>Thông tin khách hàng</h2>
                <input type="text" name="FullName" placeholder="Họ và tên" required>
                <input type="email" name="Email" placeholder="Email" required>
                <input type="password" name="Password" placeholder="Mật khẩu" required>
                <input type="text" name="PhoneNumber" placeholder="Số điện thoại" required>
                <input type="text" name="Address" placeholder="Địa chỉ" required>
                <button type="submit">Thêm người dùng</button>
            </form>
        </div>

        <!-- <footer class="footer">
            <p>© 2025 Website Bán Hàng. All rights reserved.</p>
        </footer> -->
    </div>
</body>
</html>