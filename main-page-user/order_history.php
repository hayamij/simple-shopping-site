<?php
if (session_status() == PHP_SESSION_NONE) session_start();
include '../login/connect.php';

if (!isset($_SESSION['CustomerID'])) {
    header("Location: ../login/login.php");
    exit();
}

$success = $_SESSION['success'] ?? null;
$error = $_SESSION['error'] ?? null;
unset($_SESSION['success'], $_SESSION['error']);

$cid = $_SESSION['CustomerID'];
$sql = "SELECT * FROM vw_CustomerPurchaseHistory WHERE CustomerID = ?";
$results = sqlsrv_query($conn, $sql, [$cid]);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Lịch sử mua hàng</title>
    <link rel="stylesheet" href="../main-page/style/style_index.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            padding: 8px;
            border: 1px solid #ccc;
            text-align: left;
        }
        th {
            background-color: #f8f8f8;
        }
        .cancel-btn {
            background-color: #e74c3c;
            color: white;
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            font-size: 13px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.2s ease;
        }

        .cancel-btn:hover {
            background-color: #c0392b;
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
        <h1>Lịch sử mua hàng</h1>
        <?php if ($results): ?>
            <table>
                <tr>
                    <th>Mã đơn</th>
                    <th>Ngày đặt</th>
                    <th>Trạng thái</th>
                    <th>Sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Đơn giá</th>
                    <th>Tổng</th>
                </tr>
                <?php while($row = sqlsrv_fetch_array($results, SQLSRV_FETCH_ASSOC)): ?>
                    <tr>
                        <td>#<?= $row['OrderID'] ?></td>
                        <td><?= $row['OrderDate']->format('Y-m-d') ?></td>
                        <td><?= $row['Status'] ?></td>
                        <td><?= $row['ProductName'] ?></td>
                        <td><?= $row['Quantity'] ?></td>
                        <td><?= number_format($row['UnitPrice'], 0, ',', '.') ?> VNĐ</td>
                        <td><?= number_format($row['Total'], 0, ',', '.') ?> VNĐ</td>
                        <td>
                            <?php if ($row['Status'] === 'Pending'): ?>
                                <a href="cancel_order.php?id=<?= $row['OrderID'] ?>"
                                class="cancel-btn"
                                onclick="return confirm('Bạn chắc chắn muốn hủy đơn #<?= $row['OrderID'] ?>?');">
                                Hủy đơn
                                </a>
                            <?php else: ?>
                                <span style="color:gray;">Không thể hủy</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
                <?php if ($success): ?>
                    <div style="background:#dff0d8;padding:10px;color:#3c763d;"><?= $success ?></div>
                    <?php elseif ($error): ?>
                    <div style="background:#f2dede;padding:10px;color:#a94442;"><?= $error ?></div>
                    <?php endif; ?>
            </table>
        <?php else: ?>
            <p>Không có lịch sử mua hàng.</p>
        <?php endif; ?>
    </div>
</body>
</html>