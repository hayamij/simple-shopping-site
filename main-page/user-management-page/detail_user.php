<?php
session_start();
include '../../login/connect.php';

if (!isset($_SESSION['CustomerID'])) {
    header('Location: ../../login/login.php');
    exit();
}

$customerID = $_SESSION['CustomerID'];
$result = sqlsrv_query($conn, "SELECT FullName FROM Customers WHERE CustomerID = $customerID");
$row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
if (!$row || strtolower($row['FullName']) != 'admin') {
    echo "Bạn không có quyền truy cập trang này.";
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM Customers WHERE CustomerID = ?";
    $stmt = sqlsrv_query($conn, $query, array($id));
    $user = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
} else {
    echo "Không tìm thấy người dùng.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi tiết người dùng</title>
    <link rel="stylesheet" href="../style/style_index.css">
    <style>
        .detail-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 30px;
        }

        .detail-info {
            background-color: #fff;
            padding: 20px;
            width: 400px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .detail-info h2 {
            margin-top: 0;
        }

        .detail-info p {
            margin: 10px 0;
        }

        .back-btn {
            margin-top: 20px;
            display: inline-block;
            padding: 8px 15px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }

        .back-btn:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <aside class="sidebar">
        <h2>Admin</h2>
        <a href="../home-page/home.php">Trang chủ</a>
        <a href="../product-management-page/product_management.php">Quản lý sản phẩm</a>
        <a href="../user-management-page/user_management.php">Quản lý người dùng</a>
        <a href="../order-management-page/order_management.php">Quản lý đơn hàng</a>
        <a href="../../login/login.php">Đăng xuất</a>
    </aside>

    <div class="main-content">
        <header class="header">
            <h1>Chi tiết người dùng</h1>
        </header>

        <div class="detail-container">
            <div class="detail-info">
                <h2><?php echo $user['FullName']; ?></h2>
                <p><strong>Email:</strong> <?php echo $user['Email']; ?></p>
                <p><strong>Số điện thoại:</strong> <?php echo $user['PhoneNumber']; ?></p>
                <p><strong>Địa chỉ:</strong> <?php echo $user['Address']; ?></p>
            </div>

            <a class="back-btn" href="../user-management-page/user_management.php">Quay lại</a>
        </div>

        <!-- <footer class="footer">
            <p>© 2025 Website Bán Hàng. All rights reserved.</p>
        </footer> -->
    </div>
</body>
</html>