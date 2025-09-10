<?php
    session_start();
    require '../config.php';
    require 'auth_admin.php';
?>

<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>แผงควบคุมผู้ดูแลระบบ</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    body {
        background: #f8f9fa;
    }
    .dashboard-card {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.15);
    }
</style>
</head>
<body>
    <div class="container mt-5">
        <!-- Header -->
        <div class="text-center mb-5">
            <h2 class="fw-bold">📊 ระบบผู้ดูแลระบบ</h2>
            <p class="text-muted">ยินดีต้อนรับ, 
                <span class="fw-semibold text-primary"><?= htmlspecialchars($_SESSION['username']) ?></span>
            </p>
        </div>

        <!-- Dashboard Cards -->
        <div class="row g-4">
            <div class="col-md-3">
                <div class="card dashboard-card h-100 text-center border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title text-primary">สินค้า</h5>
                        <p class="card-text text-muted">จัดการสินค้าในระบบ</p>
                        <a href="products.php" class="btn btn-primary w-100">จัดการสินค้า</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card dashboard-card h-100 text-center border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title text-success">คำสั่งซื้อ</h5>
                        <p class="card-text text-muted">ตรวจสอบและอัปเดตคำสั่งซื้อ</p>
                        <a href="orders.php" class="btn btn-success w-100">จัดการคำสั่งซื้อ</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card dashboard-card h-100 text-center border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title text-warning">สมาชิก</h5>
                        <p class="card-text text-muted">จัดการข้อมูลผู้ใช้</p>
                        <a href="users.php" class="btn btn-warning w-100">จัดการสมาชิก</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card dashboard-card h-100 text-center border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title text-dark">หมวดหมู่</h5>
                        <p class="card-text text-muted">เพิ่ม/แก้ไขหมวดหมู่สินค้า</p>
                        <a href="categories.php" class="btn btn-dark w-100">จัดการหมวดหมู่</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Logout -->
        <div class="text-center mt-5">
            <a href="../logout.php" class="btn btn-outline-secondary px-4">🚪 ออกจากระบบ</a>
        </div>
    </div>
</body>
</html>
