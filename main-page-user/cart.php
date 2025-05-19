<?php
if (session_status() == PHP_SESSION_NONE) session_start();
include '../login/connect.php';

$success = $_SESSION['success'] ?? null;
$error = $_SESSION['error'] ?? null;
unset($_SESSION['success'], $_SESSION['error']);

if (!isset($_SESSION['CustomerID'])) {
    header('Location:../login/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    foreach ($_POST['quantities'] as $productId => $qty) {
        foreach ($_SESSION['cart'] as $index => $item) {
            if ($item['ProductID'] == $productId) {
                $qty = (int)$qty;
                if ($qty <= 0) {
                    unset($_SESSION['cart'][$index]);
                } else {
                    $_SESSION['cart'][$index]['Quantity'] = $qty;
                }
            }
        }
    }
}

if (isset($_GET['delete'])) {
    $deleteId = $_GET['delete'];
    $_SESSION['cart'] = array_filter($_SESSION['cart'], function ($item) use ($deleteId) {
        return $item['ProductID'] != $deleteId;
    });
}

$cart = $_SESSION['cart'] ?? [];
$total = 0;
if (isset($_POST['checkout']) && !empty($_SESSION['cart'])) {
    $cart = $_SESSION['cart'];
    $customerID = $_SESSION['CustomerID'];
    $total = 0;

    foreach ($cart as $item) {
        $total += $item['Price'] * $item['Quantity'];
    }

    // 1. Tạo đơn hàng mới
    $insertOrder = "{CALL sp_AddOrder(?, ?, ?)}";
    $orderParams = [$customerID, $total, 'Pending'];
    $orderStmt = sqlsrv_query($conn, $insertOrder, $orderParams);

    if (!$orderStmt) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Lấy OrderID vừa tạo
    $getOrderId = sqlsrv_query($conn, "SELECT MAX(OrderID) AS OrderID FROM Orders WHERE CustomerID = ?", [$customerID]);
    $orderIdRow = sqlsrv_fetch_array($getOrderId, SQLSRV_FETCH_ASSOC);
    $orderID = $orderIdRow['OrderID'];

    // 2. Thêm từng sản phẩm vào OrderDetails
    foreach ($cart as $item) {
        $addDetail = "{CALL sp_AddProductToOrder(?, ?, ?, ?)}";
        $params = [$orderID, $item['ProductID'], $item['Quantity'], $item['Price']];
        $detailStmt = sqlsrv_query($conn, $addDetail, $params);

        if (!$detailStmt) {
            die("<script>alert('Không đủ hàng trong kho cho sản phẩm: {$item['ProductName']}');</script>");
        }
    }

    // 3. Xóa giỏ hàng sau khi đặt
    unset($_SESSION['cart']);
    echo "<script>alert('Đặt hàng thành công!'); window.location.href='cart.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Giỏ hàng</title>
    <link rel="stylesheet" href="../main-page/style/style_index.css">
    <style>
        .cart-container {
            padding: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 15px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background-color: #f5f5f5;
        }

        input[type="number"] {
            width: 60px;
        }

        .action-btn {
            padding: 5px 10px;
            color: white;
            background-color: #e74c3c;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .action-btn:hover {
            background-color: #c0392b;
        }

        .footer-bar {
            margin-top: 20px;
            text-align: right;
            font-size: 18px;
            font-weight: bold;
        }

        .update-btn {
            margin-top: 15px;
            padding: 8px 16px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .update-btn:hover {
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
            <h1>Giỏ hàng của bạn</h1>
        </header>

        <?php if ($success): ?>
            <div style="background-color: #dff0d8; padding: 10px; color: #3c763d; margin: 10px 0; border-left: 5px solid #3c763d;">
                <?= $success ?>
            </div>
        <?php elseif ($error): ?>
            <div style="background-color: #f2dede; padding: 10px; color: #a94442; margin: 10px 0; border-left: 5px solid #a94442;">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <div class="cart-container">
            <?php if (empty($cart)) { ?>
                <p>Giỏ hàng trống. <a href="product_list.php">Tiếp tục mua sắm</a></p>
            <?php } else { ?>
                <form method="POST">
                    <table>
                        <tr>
                            <th>Tên sản phẩm</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Tổng</th>
                            <th>Hành động</th>
                        </tr>
                        <?php foreach ($cart as $item): 
                            $subtotal = $item['Price'] * $item['Quantity'];
                            $total += $subtotal;
                        ?>
                            <tr>
                                <td><?= $item['ProductName'] ?></td>
                                <td><?= number_format($item['Price'], 0, ',', '.') ?> VNĐ</td>
                                <td>
                                    <input type="number" name="quantities[<?= $item['ProductID'] ?>]" value="<?= $item['Quantity'] ?>" min="0">
                                </td>
                                <td><?= number_format($subtotal, 0, ',', '.') ?> VNĐ</td>
                                <td>
                                    <a class="action-btn" href="cart.php?delete=<?= $item['ProductID'] ?>">Xóa</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>

                    <div class="footer-bar">Tổng cộng: <?= number_format($total, 0, ',', '.') ?> VNĐ</div>

                    <button type="submit" name="update" class="update-btn">Cập nhật số lượng</button>
                </form>
                <form metod="POST" action="checkout.php">
                    <button type="submit" name="checkout" class="update-btn" style="background-color: #27ae60;">Đặt hàng</button>
                </form>
            <?php } ?>
        </div>

        <!-- <footer class="footer">
            <p>© 2025 Mỹ phẩm xinh. All rights reserved.</p>
        </footer> -->
    </div>
</body>
</html>