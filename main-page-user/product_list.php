<?php
if (session_status() == PHP_SESSION_NONE) session_start();
include '../login/connect.php';
include '../main-page/home-page/functions.php';

if (!isset($_SESSION['CustomerID'])) {
    header('Location: ../login/login.php');
    exit();
}

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$products = sqlsrv_query($conn, "SELECT * FROM Products");

if (isset($_GET['search_product'])) {
    $keyword = $_GET['search_product'];
    $products = searchProductsByName($keyword);
} else {
    $products = sqlsrv_query($conn, "SELECT * FROM Products");
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách sản phẩm</title>
    <link rel="stylesheet" href="../main-page/style/style_index.css">
    <style>
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
            gap: 20px;
            padding: 20px;
        }

        .product-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            padding: 15px;
            text-align: center;
        }

        .product-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 6px;
            margin-bottom: 10px;
        }

        .product-card h3 {
            font-size: 16px;
            color: #3498db;
            margin: 10px 0 5px;
        }

        .product-card p {
            margin-bottom: 10px;
            color: #333;
        }

        .product-card button {
            padding: 8px 12px;
            background-color: #e67e22;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .product-card button:hover {
            background-color: #d35400;
        }
    </style>
</head>
<?php if ($flash): ?>
    <script>
        window.onload = function() {
            alert("<?= addslashes($flash) ?>");
        };
    </script>
<?php endif; ?>
<body>
    <aside class="sidebar">
        <h2>Xin chào</h2>
        <a href="main.php">🏠 Trang chủ</a>
        <a href="product_list.php">🛍 Danh sách sản phẩm</a>
        <a href="cart.php">🛒 Giỏ hàng</a>
        <a href="order_history.php">📜 Lịch sử mua hàng</a>
        <a href="../login/login.php">🚪 Đăng xuất</a>
    </aside>

    <div class="main-content">
        <header class="header">
            <h1>Danh sách sản phẩm</h1>
        </header>
            <form method="GET" action="product_list.php" style="margin: 20px; text-align: center;">
                <input type="text" name="search_product" placeholder="Tìm sản phẩm..." 
                    style="padding: 8px 12px; width: 300px; border-radius: 4px; border: 1px solid #ccc;">
                <button type="submit" style="padding: 8px 16px; background-color: #3498db; color: white; border: none; border-radius: 4px;">
                    Tìm kiếm
                </button>
            </form>
        <div class="product-grid">
            <?php while ($row = sqlsrv_fetch_array($products, SQLSRV_FETCH_ASSOC)) { ?>
                <div class="product-card">
                    <img src="<?= $row['ImageURL'] ?>" alt="<?= $row['ProductName'] ?>">
                    <h3><?= $row['ProductName'] ?></h3>
                    <p><strong><?= number_format($row['Price'], 0, ',', '.') ?> VNĐ</strong></p>
                    <form method="POST" action="add_to_cart.php">
                        <input type="hidden" name="ProductID" value="<?= $row['ProductID'] ?>">
                        <input type="hidden" name="ProductName" value="<?= $row['ProductName'] ?>">
                        <input type="hidden" name="Price" value="<?= $row['Price'] ?>">
                        <button type="submit">Thêm vào giỏ</button>
                    </form>
                </div>
            <?php } ?>
        </div>

        <footer class="footer">
            <p>© 2025 Mỹ phẩm xinh. All rights reserved.</p>
        </footer>
    </div>
</body>
</html>