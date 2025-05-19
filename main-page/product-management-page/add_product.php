<?php
include '../../login/connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // $productID = null;
    $name = $_POST['ProductName'];
    $category = $_POST['Category'];
    $price = $_POST['Price'];
    $quantity = $_POST['StockQuantity'];
    $image = $_POST['ImageURL'];
    $description = $_POST['Description'];

    // $productID = "00001";
    // $sql = "SELECT MAX(ProductID) AS MaxProductID FROM Products";
    // $params = array();
    // $stmt = sqlsrv_query($conn, $sql, $params);
    // if ($stmt && sqlsrv_has_rows($stmt)) {
    //     $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    //     $maxProductID = $row['MaxProductID'];
    //     if ($maxProductID) {
    //         $productID = str_pad((int)$maxProductID + 1, 5, '0', STR_PAD_LEFT);
    //     }
    // }
    
    $sql = "INSERT INTO Products (ProductName, Category, Price, StockQuantity, ImageURL, Description)
            VALUES (?, ?, ?, ?, ?, ?)";
    $params = array($name, $category, $price, $quantity, $image, $description);
    sqlsrv_query($conn, $sql, $params);
}

echo "thêm thành công";

header('Location: product_management.php');
exit();
?>