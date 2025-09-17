<?php

require '../config.php'; // เชื่อมต่อ PDO
require 'auth_admin.php'; // ตรวจสอบสิทธิ์ Admin

// เพิ่มสินค้าใหม่
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    $name = trim($_POST['product_name']);
    $description = trim($_POST['description']);
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);
    $category_id = intval($_POST['category_id']);

    if (!empty($name) && $price > 0) {
        $stmt = $conn->prepare("INSERT INTO products (product_name, description, price, stock, category_id) 
                               VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$name, $description, $price, $stock, $category_id]);
        $_SESSION['success'] = "เพิ่มสินค้าใหม่สำเร็จแล้ว ✅";
        header("Location: products.php");
        exit;
    } else {
        $_SESSION['error'] = "กรุณากรอกข้อมูลสินค้าให้ครบถ้วน ❌";
    }
}

// ลบสินค้า
if (isset($_GET['delete'])) {
    $product_id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM products WHERE product_id = ?");
    $stmt->execute([$product_id]);
    $_SESSION['success'] = "ลบสินค้าเรียบร้อยแล้ว 🗑️";
    header("Location: products.php");
    exit;
}

// ดึงรายการสินค้า
$stmt = $conn->query("SELECT p.*, c.category_name 
                     FROM products p 
                     LEFT JOIN categories c ON p.category_id = c.category_id 
                     ORDER BY p.created_at DESC");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// ดึงหมวดหมู่
$categories = $conn->query("SELECT * FROM categories ORDER BY category_name ASC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>จัดการสินค้า</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">

    <!-- หัวข้อ -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">📦 จัดการสินค้า</h2>
        <a href="index.php" class="btn btn-outline-secondary">← กลับหน้าผู้ดูแล</a>
    </div>

    <!-- แจ้งเตือน -->
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $_SESSION['error'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['success'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <!-- ฟอร์มเพิ่มสินค้าใหม่ -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="card-title">➕ เพิ่มสินค้าใหม่</h5>
            <form method="post" class="row g-3 mt-2">
                <div class="col-md-4">
                    <input type="text" name="product_name" class="form-control" placeholder="ชื่อสินค้า" required>
                </div>
                <div class="col-md-2">
                    <input type="number" step="0.01" name="price" class="form-control" placeholder="ราคา (บาท)" required>
                </div>
                <div class="col-md-2">
                    <input type="number" name="stock" class="form-control" placeholder="จำนวน" required>
                </div>
                <div class="col-md-2">
                    <select name="category_id" class="form-select" required>
                        <option value="">เลือกหมวดหมู่</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['category_id'] ?>"><?= htmlspecialchars($cat['category_name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-12">
                    <textarea name="description" class="form-control" placeholder="รายละเอียดสินค้า" rows="2"></textarea>
                </div>
                <div class="col-12">
                    <button type="submit" name="add_product" class="btn btn-primary">บันทึกสินค้า</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ตารางสินค้า -->
    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title">📋 รายการสินค้า</h5>
            <table class="table table-hover align-middle mt-3">
                <thead class="table-primary">
                    <tr>
                        <th>ชื่อสินค้า</th>
                        <th>หมวดหมู่</th>
                        <th>ราคา</th>
                        <th>คงเหลือ</th>
                        <th class="text-center">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $p): ?>
                    <tr>
                        <td><?= htmlspecialchars($p['product_name']) ?></td>
                        <td><?= htmlspecialchars($p['category_name']) ?></td>
                        <td><?= number_format($p['price'], 2) ?> บาท</td>
                        <td><?= $p['stock'] ?></td>
                        <td class="text-center">
                            <a href="edit_product.php?id=<?= $p['product_id'] ?>" class="btn btn-sm btn-warning">✏️ แก้ไข</a>
                            <a href="products.php?delete=<?= $p['product_id'] ?>" 
                               class="btn btn-sm btn-danger"
                               onclick="return confirm('คุณแน่ใจหรือไม่ที่จะลบสินค้านี้?')">🗑️ ลบ</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if (empty($products)): ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted">— ยังไม่มีสินค้า —</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
