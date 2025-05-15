<?php
include '../../login/connect.php';


if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM Products WHERE ProductID = ?";
    sqlsrv_query($conn, $sql, array($id));

}

header('Location: product_management.php');
exit();
?>