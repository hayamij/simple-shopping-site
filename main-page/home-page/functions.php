<?php
// === 1. Thêm khách hàng mới (sp_AddCustomer) ===
function addCustomer($name, $email, $password, $phone, $address) {
    global $conn;
    $sql = "{CALL sp_AddCustomer(?, ?, ?, ?, ?)}";
    $params = [$name, $email, $password, $phone, $address];
    return sqlsrv_query($conn, $sql, $params);
}

// === 2. Thêm đơn hàng mới (sp_AddOrder) ===
function addOrder($customerID, $totalAmount, $status = 'Pending') {
    global $conn;
    $sql = "{CALL sp_AddOrder(?, ?, ?)}";
    $params = [$customerID, $totalAmount, $status];
    return sqlsrv_query($conn, $sql, $params);
}

// === 3. Cập nhật trạng thái đơn hàng (sp_UpdateOrderStatus) ===
function updateOrderStatus($orderID, $newStatus) {
    global $conn;
    $sql = "{CALL sp_UpdateOrderStatus(?, ?)}";
    $params = [$orderID, $newStatus];
    return sqlsrv_query($conn, $sql, $params);
}

// === 4. Thêm sản phẩm vào giỏ (sp_AddProductToOrder) ===
function addProductToOrder($orderID, $productID, $quantity, $unitPrice) {
    global $conn;
    $sql = "{CALL sp_AddProductToOrder(?, ?, ?, ?)}";
    $params = [$orderID, $productID, $quantity, $unitPrice];
    return sqlsrv_query($conn, $sql, $params);
}

// === 5. Cập nhật số lượng trong OrderDetail (sp_UpdateOrderDetailQuantity) ===
function updateOrderDetailQuantity($orderDetailID, $newQuantity) {
    global $conn;
    $sql = "{CALL sp_UpdateOrderDetailQuantity(?, ?)}";
    $params = [$orderDetailID, $newQuantity];
    return sqlsrv_query($conn, $sql, $params);
}

// === 6. Xóa sản phẩm khỏi OrderDetail (sp_RemoveProductFromOrder) ===
function removeProductFromOrder($orderDetailID) {
    global $conn;
    $sql = "{CALL sp_RemoveProductFromOrder(?)}";
    $params = [$orderDetailID];
    return sqlsrv_query($conn, $sql, $params);
}

// === 7. Lấy danh sách đơn hàng theo khách hàng (sp_GetOrdersByCustomer) ===
function getOrdersByCustomer($customerID) {
    global $conn;
    $sql = "{CALL sp_GetOrdersByCustomer(?)}";
    $params = [$customerID];
    return sqlsrv_query($conn, $sql, $params);
}

// === 8. Tìm kiếm sản phẩm theo tên (sp_SearchProductsByName) ===
function searchProductsByName($keyword) {
    global $conn;
    $sql = "{CALL sp_SearchProductsByName(?)}";
    $params = [$keyword];
    return sqlsrv_query($conn, $sql, $params);
}
// === Views và Triggers: PHP không gọi trực tiếp trigger/view, nhưng khi SELECT từ view hoặc INSERT/UPDATE dữ liệu liên quan đến bảng, trigger sẽ tự được kích hoạt ===
// VD: SELECT * FROM vw_RevenueByMonth; // SELECT view doanh thu
// => sqlsrv_query($conn, "SELECT * FROM vw_RevenueByMonth");
?>
