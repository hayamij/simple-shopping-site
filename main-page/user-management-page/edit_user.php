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
    $query = "SELECT * FROM Customers WHERE CustomerID = ?";
    $stmt = sqlsrv_query($conn, $query, array($id));
    $user = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
} else {
    echo "Không tìm thấy người dùng.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['CustomerID'];
    $name = $_POST['FullName'];
    $email = $_POST['Email'];
    $phone = $_POST['PhoneNumber'];
    $address = $_POST['Address'];

    $sql = "UPDATE Customers SET FullName=?, Email=?, PhoneNumber=?, Address=? WHERE CustomerID=?";
    $params = array($name, $email, $phone, $address, $id);
    sqlsrv_query($conn, $sql, $params);

    header('Location: user_management.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa người dùng</title>
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

        .edit-form input {
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
            <h1>Sửa thông tin người dùng</h1>
        </header>

        <div class="edit-container">
            <form class="edit-form" method="post">
                <h2>Cập nhật người dùng</h2>
                <input type="hidden" name="CustomerID" value="<?php echo $user['CustomerID']; ?>">
                <input type="text" name="FullName" value="<?php echo $user['FullName']; ?>" placeholder="Họ tên" required>
                <input type="email" name="Email" value="<?php echo $user['Email']; ?>" placeholder="Email" required>
                <input type="text" name="PhoneNumber" value="<?php echo $user['PhoneNumber']; ?>" placeholder="Số điện thoại">
                <input type="text" name="Address" value="<?php echo $user['Address']; ?>" placeholder="Địa chỉ">
                <button type="submit">Lưu thay đổi</button>
            </form>
        </div>

        <!-- <footer class="footer">
            <p>© 2025 Website Bán Hàng. All rights reserved.</p>
        </footer> -->
    </div>
</body>
</html>