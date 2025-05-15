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

// Lấy dữ liệu sản phẩm
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM Products WHERE ProductID = ?";
    $stmt = sqlsrv_query($conn, $query, array($id));
    $product = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
} else {
    echo "Không tìm thấy sản phẩm.";
    exit();
}

// Cập nhật khi submit form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['ProductID'];
    $name = $_POST['ProductName'];
    $category = $_POST['Category'];
    $price = $_POST['Price'];
    $quantity = $_POST['StockQuantity'];
    $image = $_POST['ImageURL'];
    $description = $_POST['Description'];

    $sql = "UPDATE Products SET ProductName=?, Category=?, Price=?, StockQuantity=?, ImageURL=?, Description=? WHERE ProductID=?";
    $params = array($name, $category, $price, $quantity, $image, $description, $id);
    sqlsrv_query($conn, $sql, $params);

    header('Location: product_management.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa sản phẩm</title>
    <link rel="stylesheet" href="../style/style_index.css">
    <style>
        .edit-container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-grow: 1;
        }

        .edit-form {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            width: 400px;
            display: flex;
            flex-direction: column;
        }

        .edit-form h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .edit-form input,
        .edit-form textarea {
            margin-bottom: 12px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .edit-form button {
            padding: 10px;
            background-color: #3498db;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }

        .edit-form button:hover {
            background-color: #2980b9;
        }
    </style>
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
            <h1>Sửa thông tin sản phẩm</h1>
        </header>

        <div class="edit-container">
            <form class="edit-form" method="post">
                <h2>Cập nhật sản phẩm</h2>
                <input type="hidden" name="ProductID" value="<?php echo $product['ProductID']; ?>">
                <input type="text" name="ProductName" value="<?php echo $product['ProductName']; ?>" placeholder="Tên sản phẩm" required>
                <input type="text" name="Category" value="<?php echo $product['Category']; ?>" placeholder="Danh mục" required>
                <input type="number" step="0.01" name="Price" value="<?php echo $product['Price']; ?>" placeholder="Giá" required>
                <input type="number" name="StockQuantity" value="<?php echo $product['StockQuantity']; ?>" placeholder="Số lượng tồn" required>
                <input type="text" name="ImageURL" value="<?php echo $product['ImageURL']; ?>" placeholder="URL hình ảnh" required>
                <textarea name="Description" rows="4" placeholder="Mô tả sản phẩm"><?php echo $product['Description']; ?></textarea>
                <button type="submit">Lưu thay đổi</button>
            </form>
        </div>

        <!-- <footer class="footer">
            <p>© 2025 Website Bán Hàng. All rights reserved.</p>
        </footer> -->
    </div>
</body>
</html>