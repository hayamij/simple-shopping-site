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

// Lấy danh sách người dùng
$userQuery = "SELECT * FROM Customers";
$users = sqlsrv_query($conn, $userQuery);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quản lý người dùng</title>
    <link rel="stylesheet" href="../style/style_index.css">
    <style>
        .user-list {
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
            <h1>Quản lý Người dùng</h1>
        </header>

        <div class="user-list">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Tên</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Địa chỉ</th>
                    <th>Hành động</th>
                </tr>
                <?php while ($user = sqlsrv_fetch_array($users, SQLSRV_FETCH_ASSOC)) { ?>
                    <tr>
                        <td><?php echo $user['CustomerID']; ?></td>
                        <td><?php echo $user['FullName']; ?></td>
                        <td><?php echo $user['Email']; ?></td>
                        <td><?php echo $user['PhoneNumber']; ?></td>
                        <td><?php echo $user['Address']; ?></td>
                        <td class="actions">
                            <a href="edit_user.php?id=<?php echo $user['CustomerID']; ?>">Sửa</a>
                            <a href="delete_user.php?id=<?php echo $user['CustomerID']; ?>" onclick="return confirm('Xóa người dùng này?')">Xóa</a>
                            <a href="detail_user.php?id=<?php echo $user['CustomerID']; ?>">Chi tiết</a>
                        </td>
                    </tr>
                <?php } ?>
                <tr>
                    <td colspan="6" style="text-align: center;">
                        <a href="add_user.php" style="display: inline-book; padding: 10px 20px; background-color: #2ecc71; color: white; text-decoration: none; border-radius: 6px;">
                            + Thêm tài khoản mới
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