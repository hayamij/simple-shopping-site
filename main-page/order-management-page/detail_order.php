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

    // Lấy thông tin đơn hàng
    $query = "SELECT o.*, c.FullName 
              FROM Orders o 
              JOIN Customers c ON o.CustomerID = c.CustomerID 
              WHERE o.OrderID = ?";
    $stmt = sqlsrv_query($conn, $query, array($id));
    $order = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

    // Lấy chi tiết sản phẩm trong đơn hàng
    $detailQuery = "SELECT od.*, p.ProductName 
                    FROM OrderDetails od 
                    JOIN Products p ON od.ProductID = p.ProductID 
                    WHERE od.OrderID = ?";
    $details = sqlsrv_query($conn, $detailQuery, array($id));

    // Nếu query bị lỗi thì báo
    if ($details === false) {
        die(print_r(sqlsrv_errors(), true));
    }

} else {
    echo "Không tìm thấy đơn hàng.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi tiết đơn hàng</title>
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
            width: 500px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .detail-info h2 {
            margin-top: 0;
        }

        .detail-info p {
            margin: 10px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 10px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #3498db;
            color: white;
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
            <h1>Chi tiết đơn hàng</h1>
        </header>

        <div class="detail-container">
            <!-- Thông tin đơn hàng -->
            <div class="detail-info">
                <h2>Đơn hàng #<?php echo $order['OrderID']; ?></h2>
                <p><strong>Khách hàng:</strong> <?php echo $order['FullName']; ?></p>
                <p><strong>Ngày đặt:</strong> <?php echo $order['OrderDate']->format('Y-m-d'); ?></p>
                <p><strong>Trạng thái:</strong> <?php echo $order['Status']; ?></p>
            </div>

            <!-- Bảng chi tiết sản phẩm -->
            <h3>Danh sách sản phẩm</h3>
            <table>
                <tr>
                    <th>ID SP</th>
                    <th>Tên SP</th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                </tr>
                <?php if ($details !== false) { ?>
                    <?php while ($detail = sqlsrv_fetch_array($details, SQLSRV_FETCH_ASSOC)) { ?>
                        <tr>
                            <td><?php echo $detail['ProductID']; ?></td>
                            <td><?php echo $detail['ProductName']; ?></td>
                            <td><?php echo $detail['Quantity']; ?></td>
                            <td><?php echo number_format($detail['UnitPrice'], 0, ',', '.'); ?> VNĐ</td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="4">Không có dữ liệu chi tiết đơn hàng.</td>
                    </tr>
                <?php } ?>
            </table>

            <a class="back-btn" href="order_management.php">Quay lại</a>
        </div>

        <!-- <footer class="footer">
            <p>© 2025 Website Bán Hàng. All rights reserved.</p>
        </footer> -->
    </div>
</body>
</html>