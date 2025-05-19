<?php
include 'connect.php';
 
$registerError = "";
$successMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //customerid tự động tăng, giá trị mặc định là 00001
    // $customerID = null;
    $fullName = $_POST["fullname"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $password = $_POST["password"];
    $address = $_POST["address"];

    // Kiểm tra email hoặc số điện thoại đã tồn tại
    $checkSql = "SELECT * FROM Customers WHERE Email = ? OR PhoneNumber = ?";
    $checkParams = array($email, $phone);
    $checkStmt = sqlsrv_query($conn, $checkSql, $checkParams);

    if ($checkStmt && sqlsrv_has_rows($checkStmt)) {
        $registerError = "Email hoặc số điện thoại đã được đăng ký";
    } else {
        // check customerid đã tồn tại, +1 để tạo customerid mới
        // $customerID = "00001";
        // $sql = "SELECT MAX(CustomerID) AS MaxCustomerID FROM Customers";
        // $params = array();
        // $stmt = sqlsrv_query($conn, $sql, $params);
        // if ($stmt && sqlsrv_has_rows($stmt)) {
        //     $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        //     $maxCustomerID = $row['MaxCustomerID'];
        //     if ($maxCustomerID) {
        //         $customerID = str_pad((int)$maxCustomerID + 1, 5, '0', STR_PAD_LEFT);
        //     }
        // }
        // Hashing
        $hashedPassword = hash('sha256', $password);
        $insertSql = "INSERT INTO Customers (FullName, Email, Password, PhoneNumber, Address, CreatedAt) VALUES (?, ?, ?, ?, ?, GETDATE())";
        $insertParams = array($fullName, $email, $hashedPassword, $phone, $address);
        $insertStmt = sqlsrv_query($conn, $insertSql, $insertParams);

        if ($insertStmt) {
            $successMessage = "Đăng ký thành công. <a href='login.php'>Đăng nhập ngay</a>";
        } else {
            $registerError = "Đăng ký thất bại, vui lòng thử lại.";
            if (($errors = sqlsrv_errors()) != null) {
                foreach ($errors as $error) {
                    $registerError .= "SQLSTATE: " . $error['SQLSTATE'] . "<br />";
                    $registerError .= "Code: " . $error['code'] . "<br />";
                    $registerError .= "Message: " . $error['message'] . "<br />";
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký</title>
    <link rel="stylesheet" href="style_login.css">
</head>
<body>
    <div class="login-container">
        <h2>Đăng ký tài khoản</h2>
        <?php if ($registerError): ?>
            <p class="error"><?= $registerError ?></p>
        <?php endif; ?>
        <?php if ($successMessage): ?>
            <p class="success"><?= $successMessage ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <input type="text" name="fullname" placeholder="Họ và tên" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="phone" placeholder="Số điện thoại" required>
            <input type="password" name="password" placeholder="Mật khẩu" required>
            <input type="text" name="address" placeholder="Địa chỉ" required>
            <button type="submit">Đăng ký</button>
        </form>
        <p class="footer-text">Đã có tài khoản? <a href="login.php">Đăng nhập</a></p>
    </div>
</body>
</html>