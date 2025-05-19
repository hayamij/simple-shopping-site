<?php
session_start();
include 'connect.php';

$loginError = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];
    // Hashing
    $storedHash = null;
    $sql = "SELECT Password FROM Customers WHERE Email = ?";
    $params = array($email);
    $stmt = sqlsrv_query($conn, $sql, $params);
    if ($stmt && sqlsrv_has_rows($stmt)) {
        $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
        $storedHash = $row["Password"];
    }
    // Kiểm tra mật khẩu
    if ($storedHash && hash_equals($storedHash, hash('sha256', $password))) {
        $sql = "SELECT CustomerID, FullName FROM Customers WHERE Email = ?";
        $params = array($email);
        $stmt = sqlsrv_query($conn, $sql, $params);
        if ($stmt && sqlsrv_has_rows($stmt)) {
            $user = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

            $_SESSION["CustomerID"] = $user["CustomerID"];
            $_SESSION["FullName"] = $user["FullName"];
            header("Location: ../main-page/home-page/home.php"); // hoặc home.php
            exit();
        }
    } else {
        $loginError = "Sai email hoặc mật khẩu";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="style_login.css">
</head>
<body>
    <div class="login-container">
        <h2>Đăng nhập</h2>
        <?php if ($loginError): ?>
            <p class="error"><?= $loginError ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <input type="text" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Mật khẩu" required>
            <button type="submit">Đăng nhập</button>
        </form>
        <p class="footer-text">Chưa có tài khoản? <a href="register.php">Đăng ký</a></p>
    </div>
</body>
</html>