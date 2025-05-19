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
    $sql = "DELETE FROM Orders WHERE OrderID = ?";
    sqlsrv_query($conn, $sql, array($id));

    if ($result === false) {
        die(print_r(sqlsrv_errors(), true));
    }

}

header('Location: order_management.php');
exit();
?>