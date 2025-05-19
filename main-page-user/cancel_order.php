<?php
if (session_status() == PHP_SESSION_NONE) session_start();
include '../login/connect.php';

if (!isset($_SESSION['CustomerID'])) {
    header('Location: ../login/login.php');
    exit();
}

$customerID = $_SESSION['CustomerID'];
$orderID = $_GET['id'] ?? null;

if ($orderID) {
    // Kiểm tra đơn này có thuộc khách hiện tại không, và có trạng thái Pending không
    $check = sqlsrv_query($conn, "SELECT * FROM Orders WHERE OrderID = ? AND CustomerID = ? AND Status = 'Pending'", [$orderID, $customerID]);
    if (sqlsrv_has_rows($check)) {
        // Hủy đơn: update trạng thái
        $update = sqlsrv_query($conn, "UPDATE Orders SET Status = 'Cancelled' WHERE OrderID = ?", [$orderID]);
        if ($update) {
            $_SESSION['success'] = "Đã hủy đơn hàng #$orderID thành công.";
        } else {
            $_SESSION['error'] = "Có lỗi xảy ra khi hủy đơn.";
        }
    } else {
        $_SESSION['error'] = "Không thể hủy đơn này (không thuộc bạn hoặc đã xử lý).";
    }
}

header("Location: order_history.php");
exit();
?>