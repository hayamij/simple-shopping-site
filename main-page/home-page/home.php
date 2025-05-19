<?php
session_start();
include '../../login/connect.php';
include 'functions.php';

if (!isset($_SESSION['CustomerID'])) {
    header('Location: ../../login/login.php');
    exit();
}

$customerID = $_SESSION['CustomerID'];
$result = sqlsrv_query($conn, "SELECT FullName FROM Customers WHERE CustomerID = $customerID");
$row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
if (!$row || strtolower($row['FullName']) != 'admin') {
    header("Location: ../../main-page-user/main.php"); // hoặc home.php
    exit();
}
// Xử lý tìm kiếm sản phẩm
$searchResults = null;
if (isset($_GET['search_product'])) {
    $keyword = $_GET['search_product'];
    $searchResults = searchProductsByName($keyword);
}

// Xử lý xem đơn theo khách hàng
$orderResults = null;
if (isset($_GET['customer_id'])) {
    $customerID = (int)$_GET['customer_id'];
    $orderResults = getOrdersByCustomer($customerID);
}

// Lấy doanh thu theo tháng
$revenueResults = sqlsrv_query($conn, "SELECT * FROM vw_RevenueByMonth");

// Lịch sử mua hàng
$historyResults = null;
if (isset($_GET['history_customer_id'])) {
    $cid = (int)$_GET['history_customer_id'];
    $sql = "SELECT * FROM vw_CustomerPurchaseHistory WHERE CustomerID = ?";
    $historyResults = sqlsrv_query($conn, $sql, [$cid]);
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Trang Admin - Tương tác chức năng</title>
    <link rel="stylesheet" href="../style/style_index.css">
    <style>
        .form-section {
            padding: 20px;
            background: #fff;
            margin: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        input[type=text] {
            padding: 8px;
            width: 250px;
            margin-right: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .submit-btn {
            padding: 8px 14px;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 4px;
        }
    </style>
</head>
<body>
<aside class="sidebar">
    <h2>Admin</h2>
    <a href="home.php">Trang chủ</a>
    <a href="../user-management-page/user_management.php">Quản lý người dùng</a>
    <a href="../order-management-page/order_management.php">Quản lý đơn hàng</a>
    <a href="../product-management-page/product_management.php">Quản lý sản phẩm</a>
    <a href="../../login/login.php">Đăng xuất</a>
</aside>

<div class="main-content">
    <header class="header"><h1>Bảng điều khiển chức năng</h1></header>

    <div class="form-section">
        <h2>🔎 Tìm sản phẩm</h2>
        <form method="GET">
            <input type="text" name="search_product" placeholder="Nhập tên sản phẩm...">
            <button type="submit" class="submit-btn">Tìm</button>
        </form>
        <?php if ($searchResults): ?>
            <table>
                <tr><th>Tên</th><th>Giá</th><th>Loại</th></tr>
                <?php while($p = sqlsrv_fetch_array($searchResults, SQLSRV_FETCH_ASSOC)): ?>
                    <tr>
                        <td><?= $p['ProductName'] ?></td>
                        <td><?= number_format($p['Price'], 0, ',', '.') ?> VNĐ</td>
                        <td><?= $p['Category'] ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php endif; ?>
    </div>

    <div class="form-section">
        <h2>📋 Xem đơn hàng của khách</h2>
        <form method="GET">
            <input type="text" name="customer_id" placeholder="Nhập CustomerID...">
            <button type="submit" class="submit-btn">Lọc</button>
        </form>
        <?php if ($orderResults): ?>
            <table>
                <tr><th>Mã đơn</th><th>Ngày đặt</th><th>Tổng tiền</th><th>Trạng thái</th></tr>
                <?php while($o = sqlsrv_fetch_array($orderResults, SQLSRV_FETCH_ASSOC)): ?>
                    <tr>
                        <td>#<?= $o['OrderID'] ?></td>
                        <td><?= $o['OrderDate']->format('Y-m-d') ?></td>
                        <td><?= number_format($o['TotalAmount'], 0, ',', '.') ?> VNĐ</td>
                        <td><?= $o['Status'] ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php endif; ?>
    </div>

    <div class="form-section">
        <h2>📊 Doanh thu theo tháng</h2>
        <table>
            <tr><th>Tháng</th><th>Doanh thu</th><th>Số đơn</th></tr>
            <?php while($rev = sqlsrv_fetch_array($revenueResults, SQLSRV_FETCH_ASSOC)): ?>
                <tr>
                    <td><?= $rev['YearMonth'] ?></td>
                    <td><?= number_format($rev['TotalRevenue'], 0, ',', '.') ?> VNĐ</td>
                    <td><?= $rev['TotalOrders'] ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
    
    <div class="form-section">
        <h2>🧾 Lịch sử mua hàng của khách</h2>
        <form method="GET">
            <input type="text" name="history_customer_id" placeholder="Nhập CustomerID...">
            <button type="submit" class="submit-btn">Xem lịch sử</button>
        </form>
        <?php if ($historyResults): ?>
            <table>
                <tr>
                    <th>Khách</th>
                    <th>Mã đơn</th>
                    <th>Ngày</th>
                    <th>Trạng thái</th>
                    <th>Sản phẩm</th>
                    <th>SL</th>
                    <th>Đơn giá</th>
                    <th>Tổng</th>
                </tr>
                <?php while($row = sqlsrv_fetch_array($historyResults, SQLSRV_FETCH_ASSOC)): ?>
                    <tr>
                        <td><?= $row['FullName'] ?></td>
                        <td>#<?= $row['OrderID'] ?></td>
                        <td><?= $row['OrderDate']->format('Y-m-d') ?></td>
                        <td><?= $row['Status'] ?></td>
                        <td><?= $row['ProductName'] ?></td>
                        <td><?= $row['Quantity'] ?></td>
                        <td><?= number_format($row['UnitPrice'], 0, ',', '.') ?> VNĐ</td>
                        <td><?= number_format($row['Total'], 0, ',', '.') ?> VNĐ</td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php endif; ?>
    </div>

    <footer class="footer">
        <p>© 2025 Hệ thống quản lý mỹ phẩm. All rights reserved.</p>
    </footer>
</div>
</body>
</html>