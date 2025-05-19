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

// Lấy danh sách sản phẩm
$productQuery = "SELECT * FROM Products";
$products = sqlsrv_query($conn, $productQuery);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Admin - Quản lý Sản phẩm</title>
    <link rel="stylesheet" href="../style/style_index.css">
</head>
<body>
    <aside class="sidebar">
        <h2>Admin</h2>
        <a href="../home-page/home.php">Trang chủ</a>
        <a href="../product-management-page/product_management.php">Quản lý sản phẩm</a>
        <a href="../user-management-page/user_management.php">Quản lý người dùng</a>
        <a href="../order-management-page/order_management.php">Quản lý đơn hàng</a>
        <a href="../../login/login.php">Đăng xuất</a>
    </aside>

    <div class="main-content">
        <header class="header">
            <h1>Website Bán Hàng - Trang Quản Trị</h1>
        </header>

        <div class="grid-container">
            <?php while ($product = sqlsrv_fetch_array($products, SQLSRV_FETCH_ASSOC)) { ?>
                <div class="product-card">
                    <img src="<?php echo $product['ImageURL']; ?>" alt="Ảnh sản phẩm">
                    <h3><?php echo $product['ProductName']; ?></h3>
                    <p>Giá: <?php echo number_format($product['Price'], 0, ',', '.'); ?> VNĐ</p>
                    <div class="actions">
                        <a href="edit_product.php?id=<?php echo $product['ProductID']; ?>">Sửa</a>
                        <a href="../product-management-page/delete_product.php?id=<?php echo $product['ProductID']; ?>" onclick="return confirm('Xóa sản phẩm này?')">Xóa</a>
                        <a href="detail_product.php?id=<?php echo $product['ProductID']; ?>">Chi tiết</a>
                    </div>
                </div>
            <?php } ?>

            <!-- Ô dấu cộng -->
            <div class="product-card add-new" onclick="document.getElementById('addForm').style.display='block'">
                <span>+</span>
                <p>Thêm sản phẩm</p>
            </div>
        </div>

        <!-- <footer class="footer">
            <p>© 2025 Website Bán Hàng. All rights reserved.</p>
        </footer> -->
    </div>

    <!-- Form thêm sản phẩm -->
    <div id="addForm" class="modal">
        <form action="add_product.php" method="post">
            <h2>Thêm sản phẩm mới</h2>
            <input type="text" name="ProductName" placeholder="Tên sản phẩm" required>
            <input type="text" name="Category" placeholder="Danh mục" required>
            <input type="number" step="0.01" name="Price" placeholder="Giá" required>
            <input type="number" name="StockQuantity" placeholder="Số lượng tồn" required>
            <input type="text" name="ImageURL" placeholder="URL hình ảnh" required>
            <textarea name="Description" placeholder="Mô tả sản phẩm"></textarea>
            <button type="submit">Thêm</button>
            <button type="button" onclick="document.getElementById('addForm').style.display='none'">Hủy</button>
        </form>
    </div>
</body>
</html>