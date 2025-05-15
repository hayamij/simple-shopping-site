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
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Admin - Trang chủ</title>
    <link rel="stylesheet" href="../style/style_index.css">
    <style>
        .banner-list {
            display: flex;
            overflow-x: auto;
            gap: 15px;
            padding: 20px 20px 0 20px;
            height: 350px;
        }

        .banner-list img {
            height: 100%;
            flex-shrink: 0;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }

        .event-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            margin: -60px 20px 20px 20px;
            position: relative;
            z-index: 2;
        }

        .event-card {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            text-align: center;
        }

        .event-card img {
            max-width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 4px;
            margin-bottom: 15px;
        }

        .event-card h3 {
            margin: 10px 0;
            color: #3498db;
        }

        .event-card p {
            color: #555;
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
            <h1>Chào mừng đến Trang quản trị</h1>
        </header>

        <div class="detail-container">
            <!-- Banner dạng list ngang -->
            <div class="banner-list">
                <img src="image/banner1.jpg" alt="Banner 1">
                <img src="image/banner2.jpg" alt="Banner 2">
                <img src="image/banner3.jpg" alt="Banner 3">
                <img src="image/banner4.jpg" alt="Banner 4">
            </div>

            <!-- Danh sách sự kiện -->
            <h2 style="padding-left: 20px;">Sự kiện & Khuyến mãi</h2>
            <div class="event-section">
                <div class="event-card">
                    <img src="image/event1.jpg" alt="Sự kiện 1">
                    <h3>SALE 50%</h3>
                    <p>Giảm giá cực sốc cho toàn bộ sản phẩm trong tuần này.</p>
                </div>
                <div class="event-card">
                    <img src="image/event2.jpg" alt="Sự kiện 2">
                    <h3>EVENT MỪNG SINH NHẬT</h3>
                    <p>Tham gia minigame nhận ngay voucher trị giá 100K.</p>
                </div>
                <div class="event-card">
                    <img src="image/event3.jpg" alt="Sự kiện 3">
                    <h3>TOP BÁN CHẠY</h3>
                    <p>Cùng khám phá những sản phẩm hot nhất tháng này.</p>
                </div>
            </div>
        </div>

        <!-- <footer class="footer">
            <p>© 2025 Website Bán Hàng. All rights reserved.</p>
        </footer> -->
    </div>
</body>
</html>