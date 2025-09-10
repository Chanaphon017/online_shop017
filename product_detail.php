<?php
session_start();
require_once 'config.php';

if(!isset($_GET['id'])){
    header('Location: index.php');
    exit();
}

$product_id = $_GET['id'];
$isLoggedIn = isset($_SESSION['user_id']);

$stmt = $conn->prepare("SELECT p.*, c.category_name
    FROM products p
    LEFT JOIN categories c ON p.category_id = c.category_id
    WHERE p.product_id = ?");
$stmt->execute([$product_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($product['product_name']) ?> - รายละเอียดสินค้า</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.1);
        }
        .price {
            font-size: 1.5rem;
            font-weight: bold;
            color: #28a745;
        }
    </style>
</head>
<body>
<div class="container mt-5">


    <a href="index.php" class="btn btn-outline-secondary mb-4">← กลับหน้ารายการสินค้า</a>

    <div class="card p-4">
        <div class="row">
            <div class="col-md-7">
                <h2 class="fw-bold"><?= htmlspecialchars($product['product_name']) ?></h2>
                <h6 class="text-muted mb-3">หมวดหมู่: <?= htmlspecialchars($product['category_name']) ?></h6>

                <p class="price mb-3">💰 <?= number_format($product['price'], 2) ?> บาท</p>
                <p><strong>คงเหลือ:</strong> <?= htmlspecialchars($product['stock']) ?> ชิ้น</p>

    
                <?php if ($isLoggedIn): ?>
                    <?php if ($product['stock'] > 0): ?>
                        <form action="cart.php" method="post" class="mt-4">
                            <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                            <div class="input-group mb-3" style="max-width: 200px;">
                                <label class="input-group-text" for="quantity">จำนวน</label>
                                <input type="number" name="quantity" id="quantity" value="1" min="1" 
                                       max="<?= $product['stock'] ?>" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-success btn-lg">+ เพิ่มในตะกร้า</button>
                        </form>
                    <?php else: ?>
                        <div class="alert alert-danger mt-4">สินค้าหมดชั่วคราว ❌</div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="alert alert-info mt-4">กรุณาเข้าสู่ระบบเพื่อสั่งซื้อสินค้า</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>
