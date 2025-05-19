<?php
if (session_status() == PHP_SESSION_NONE) session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productID = $_POST['ProductID'];
    $name = $_POST['ProductName'];
    $price = $_POST['Price'];

    $found = false;

    // Khởi tạo giỏ nếu chưa có
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Nếu sản phẩm đã có thì cộng thêm số lượng
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['ProductID'] == $productID) {
            $item['Quantity'] += 1;
            $found = true;
            break;
        }
    }

    // Nếu chưa có thì thêm mới
    if (!$found) {
        $_SESSION['cart'][] = [
            'ProductID' => $productID,
            'ProductName' => $name,
            'Price' => $price,
            'Quantity' => 1
        ];
    }

    $_SESSION['flash'] = "Đã thêm $name vào giỏ hàng!";
}

// Quay lại trang sản phẩm
header('Location: product_list.php');
exit();
?>