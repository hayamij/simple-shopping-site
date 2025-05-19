<?php
include '../../login/connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM Customers WHERE CustomerID = ?";
    sqlsrv_query($conn, $sql, array($id));

}

header('Location: user_management.php');
exit();
?>