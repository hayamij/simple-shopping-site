<?php
if (session_status() == PHP_SESSION_NONE) session_start();
include '../login/connect.php';

if (!isset($_SESSION['CustomerID']) || empty($_SESSION['cart'])) {
    header('Location: cart.php');
    exit();
}

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
    $_SESSION['error'] = "Không đủ hàng trong kho cho sản phẩm: " . $item['ProductName'];
    header("Location: cart.php");
    exit();
}

// 2. Lấy OrderID vừa tạo
$getOrderId = sqlsrv_query($conn, "SELECT MAX(OrderID) AS OrderID FROM Orders WHERE CustomerID = ?", [$customerID]);
$orderIdRow = sqlsrv_fetch_array($getOrderId, SQLSRV_FETCH_ASSOC);
$orderID = $orderIdRow['OrderID'];

// 3. Thêm từng sản phẩm vào chi tiết đơn hàng
foreach ($cart as $item) {
    $addDetail = "{CALL sp_AddProductToOrder(?, ?, ?, ?)}";
    $params = [$orderID, $item['ProductID'], $item['Quantity'], $item['Price']];
    $detailStmt = sqlsrv_query($conn, $addDetail, $params);

    if (!$detailStmt) {
        // Lỗi do trigger kiểm tra tồn kho
        $_SESSION['error'] = "Không đủ hàng trong kho cho sản phẩm: " . $item['ProductName'];
        header("Location: cart.php");
        exit();
    }
}

// 4. Thành công → xóa giỏ
unset($_SESSION['cart']);
$_SESSION['success'] = "Đặt hàng thành công! Mã đơn: #$orderID";
header("Location: cart.php");
exit();
?>