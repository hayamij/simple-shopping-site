<?php
if (session_status() == PHP_SESSION_NONE) session_start();
include '../../login/connect.php';

// Lấy danh sách khách hàng cho dropdown
$customers = sqlsrv_query($conn, "SELECT CustomerID, FullName FROM Customers");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customerID = $_POST['CustomerID'];
    $total = $_POST['TotalAmount'];
    $status = $_POST['Status'];

    $sql = "{CALL sp_AddOrder(?, ?, ?)}";
    $params = array($customerID, $total, $status);
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
    <title>Thêm đơn hàng</title>
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
            <h1>Thêm đơn hàng mới</h1>
        </header>

        <div class="form-container">
            <form method="POST">
                <h2>Thông tin đơn hàng</h2>
                <label>Khách hàng:</label>
                <select name="CustomerID" required>
                    <option value="">-- Chọn khách hàng --</option>
                    <?php while ($cus = sqlsrv_fetch_array($customers, SQLSRV_FETCH_ASSOC)) { ?>
                        <option value="<?= $cus['CustomerID'] ?>">
                            <?= $cus['FullName'] ?>
                        </option>
                    <?php } ?>
                </select>

                <label>Tổng tiền (VND):</label>
                <input type="number" name="TotalAmount" placeholder="Nhập tổng tiền" required>

                <label>Trạng thái:</label>
                <select name="Status" required>
                    <option value="Pending">Pending</option>
                    <option value="Completed">Completed</option>
                    <option value="Cancelled">Cancelled</option>
                </select>

                <button type="submit">Thêm đơn hàng</button>
            </form>
        </div>

        <footer class="footer">
            <p>© 2025 Website Bán Hàng. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>