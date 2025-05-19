<?php
if (session_status() == PHP_SESSION_NONE) session_start();
include '../login/connect.php';

if (!isset($_SESSION['CustomerID'])) {
    header('Location: ../login/login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang người dùng</title>
    <link rel="stylesheet" href="../main-page/style/style_index.css">
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
        <h2>Xin chào</h2>
        <a href="main.php">🏠 Trang chủ</a>
        <a href="product_list.php">🛍 Danh sách sản phẩm</a>
        <a href="cart.php">🛒 Giỏ hàng</a>
        <a href="order_history.php">📜 Lịch sử mua hàng</a>
        <a href="../login/login.php">🚪 Đăng xuất</a>
    </aside>

    <div class="main-content">
        <header class="header">
            <h1>Chào mừng bạn đến với cửa hàng mỹ phẩm</h1>
        </header>

        <div class="detail-container">
            <!-- Banner ngang -->
            <div class="banner-list">
                <img src="image/banner1.jpg" alt="Banner 1">
                <img src="image/banner2.jpg" alt="Banner 2">
                <img src="image/banner3.jpg" alt="Banner 3">
            </div>

            <!-- Các khuyến mãi nổi bật -->
            <h2 style="padding-left: 20px;">Ưu đãi & Khuyến mãi</h2>
            <div class="event-section">
                <div class="event-card">
                    <img src="image/event1.jpg" alt="Sale 1">
                    <h3>Giảm giá 50%</h3>
                    <p>Ưu đãi siêu hot mùa hè cho toàn bộ dòng sản phẩm dưỡng da.</p>
                </div>
                <div class="event-card">
                    <img src="image/event2.jpg" alt="Sale 2">
                    <h3>FREESHIP toàn quốc</h3>
                    <p>Miễn phí vận chuyển đơn từ 300K trên toàn quốc.</p>
                </div>
                <div class="event-card">
                    <img src="image/event3.jpg" alt="Sale 3">
                    <h3>Quà tặng kèm</h3>
                    <p>Nhận quà tặng mini size khi mua bất kỳ sản phẩm nào.</p>
                </div>
            </div>
        </div>

        <!-- <footer class="footer">
            <p>© 2025 Mỹ phẩm xinh. All rights reserved.</p>
        </footer> -->
    </div>
</body>
</html>