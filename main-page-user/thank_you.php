<?php
$orderID = $_GET['order_id'] ?? '???';
?>
<!DOCTYPE html>
<html lang="vi">
<head><meta charset="UTF-8"><title>Đặt hàng thành công</title></head>
<body>
    <h1>✅ Cảm ơn bạn đã đặt hàng!</h1>
    <p>Mã đơn hàng của bạn là: <strong>#<?= $orderID ?></strong></p>
    <a href="product_list.php">Tiếp tục mua sắm</a>
</body>
</html>