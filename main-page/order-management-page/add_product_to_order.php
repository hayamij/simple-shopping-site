<?php
if (session_status() == PHP_SESSION_NONE) session_start();
include '../../login/connect.php';

// Lấy danh sách đơn hàng và sản phẩm
$orders = sqlsrv_query($conn, "SELECT OrderID FROM Orders");
$products = sqlsrv_query($conn, "SELECT ProductID, ProductName FROM Products");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $orderID = $_POST['OrderID'];
    $productID = $_POST['ProductID'];
    $quantity = $_POST['Quantity'];
    $unitPrice = $_POST['UnitPrice'];

    $sql = "{CALL sp_AddProductToOrder(?, ?, ?, ?)}";
    $params = array($orderID, $productID, $quantity, $unitPrice);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    header("Location: ../order-management-page/order_management.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thêm sản phẩm vào đơn hàng</title>
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

        select, input[type="number"] {
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
            <h1>Thêm sản phẩm vào đơn hàng</h1>
        </header>

        <div class="form-container">
            <form method="POST">
                <h2>Thông tin chi tiết</h2>

                <label>Đơn hàng:</label>
                <select name="OrderID" required>
                    <option value="">-- Chọn đơn hàng --</option>
                    <?php while ($order = sqlsrv_fetch_array($orders, SQLSRV_FETCH_ASSOC)) { ?>
                        <option value="<?= $order['OrderID'] ?>">Đơn #<?= $order['OrderID'] ?></option>
                    <?php } ?>
                </select>

                <label>Sản phẩm:</label>
                <select name="ProductID" required>
                    <option value="">-- Chọn sản phẩm --</option>
                    <?php while ($prod = sqlsrv_fetch_array($products, SQLSRV_FETCH_ASSOC)) { ?>
                        <option value="<?= $prod['ProductID'] ?>"><?= $prod['ProductName'] ?></option>
                    <?php } ?>
                </select>

                <label>Số lượng:</label>
                <input type="number" name="Quantity" min="1" required>

                <label>Đơn giá (VND):</label>
                <input type="number" name="UnitPrice" step="0.01" required>

                <button type="submit">Thêm sản phẩm vào đơn</button>
            </form>
        </div>

        <!-- <footer class="footer">
            <p>© 2025 Website Bán Hàng. All rights reserved.</p>
        </footer> -->
    </div>
</body>
</html>