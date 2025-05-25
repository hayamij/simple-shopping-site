<?php
session_start();
include '../login/connect.php';
// if (!isset($_SESSION['CustomerID']) || !isset($_GET['product_id'])) {
//     header('Location: product_list.php');
//     exit();
// }
$productId = $_GET['ProductID'];
$query = "SELECT * FROM Products WHERE ProductID = ?";
$stmt = sqlsrv_query($conn, $query, array($productId));
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}
$product = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
if ($product === false) {
    echo "Không tìm thấy sản phẩm.";
    exit();
}
if (session_status() == PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['CustomerID'])) {
    header('Location: ../login/login.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi tiết Sản phẩm</title>
    <link rel="stylesheet" href="../main-page/style/style_index.css">
    <style>
        .detail-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 30px;
        }

        .detail-container img {
            max-width: 300px;
            height: auto;
            margin-bottom: 20px;
            border: 3px solid #ddd;
            border-radius: 8px;
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
        <h2>Xin chào</h2>
            <a href="main.php">🏠 Trang chủ</a>
            <a href="product_list.php">🛍 Danh sách sản phẩm</a>
            <a href="cart.php">🛒 Giỏ hàng</a>
            <a href="order_history.php">📜 Lịch sử mua hàng</a>
            <a href="../login/login.php">🚪 Đăng xuất</a>
    </aside>

    <div class="main-content">
        <header class="header">
            <h1>Chi tiết Sản phẩm</h1>
        </header>

        <div class="detail-container">
            <img src="<?php echo $product['ImageURL']; ?>" alt="Ảnh sản phẩm">
            <div class="detail-info">
                <h2><?php echo $product['ProductName']; ?></h2>
                <p><strong>Danh mục:</strong> <?php echo $product['Category']; ?></p>
                <p><strong>Giá:</strong> <?php echo number_format($product['Price'], 0, ',', '.'); ?> VNĐ</p>
                <p><strong>Số lượng tồn:</strong> <?php echo $product['StockQuantity']; ?></p>
                <p><strong>Mô tả:</strong><br><?php echo nl2br($product['Description']); ?></p>
            </div>
            <a class="back-btn" href="product_list.php">Quay lại</a>
        </div>

        <footer class="footer">
            <p>© 2025 Website Bán Hàng. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>