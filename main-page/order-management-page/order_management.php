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

// Lấy danh sách đơn hàng + tên khách
$orderQuery = "SELECT o.OrderID, o.CustomerID, c.FullName, o.OrderDate, o.Status
               FROM Orders o
               JOIN Customers c ON o.CustomerID = c.CustomerID";
$orders = sqlsrv_query($conn, $orderQuery);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý đơn hàng</title>
    <link rel="stylesheet" href="../style/style_index.css">
    <style>
        .order-list {
            flex-grow: 1;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #3498db;
            color: white;
        }

        .actions a {
            display: inline-block;
            margin: 0 5px;
            padding: 5px 10px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-size: 13px;
        }

        .actions a:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <aside class="sidebar">
        <h2>Admin</h2>
        <a href="../home-page/home.php">🏠 Trang chủ</a>
        <a href="../product-management-page/product_management.php">🛍 Quản lý sản phẩm</a>
        <a href="../user-management-page/user_management.php">👤 Quản lý người dùng</a>
        <a href="../order-management-page/order_management.php">📜 Quản lý đơn hàng</a>
        <a href="../../login/login.php">🚪 Đăng xuất</a>
    </aside>

    <div class="main-content">
        <header class="header">
            <h1>Quản lý Đơn hàng</h1>
        </header>

        <div class="order-list">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Khách hàng</th>
                    <th>Ngày đặt</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
                <?php while ($order = sqlsrv_fetch_array($orders, SQLSRV_FETCH_ASSOC)) { ?>
                    <tr>
                        <td><?php echo $order['OrderID']; ?></td>
                        <td><?php echo $order['FullName']; ?></td>
                        <td><?php echo $order['OrderDate']->format('Y-m-d'); ?></td>
                        <td><?php echo $order['Status']; ?></td>
                        <td class="actions">
                            <a href="edit_order.php?id=<?php echo $order['OrderID']; ?>">Sửa</a>
                            <a href="delete_order.php?id=<?php echo $order['OrderID']; ?>" onclick="return confirm('Xóa đơn hàng này?')">Xóa</a>
                            <a href="detail_order.php?id=<?php echo $order['OrderID']; ?>">Chi tiết</a>
                        </td>
                    </tr>
                <?php } ?>
                <tr>
                    <td colspan="6" style="text-align: center;">
                        <a href="add_order.php" style="display: inline-book; padding: 10px 20px; background-color: #2ecc71; color: white; text-decoration: none; border-radius: 6px;">
                            Thêm đơn hàng mới
                        </a>
                        <br>
                        <br>
                        <br>
                        <a href="add_product_to_order.php" style="display: inline-book; padding: 10px 20px; background-color: #2ecc71; color: white; text-decoration: none; border-radius: 6px;">
                            Thêm sản phẩm vào đơn
                        </a>
                    </td>
                </tr>
            </table>
        </div>

        <!-- <footer class="footer">
            <p>© 2025 Website Bán Hàng. All rights reserved.</p>
        </footer> -->
    </div>
</body>
</html>