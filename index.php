<?php
session_start();

// ป้องกันการเข้าถึงโดยตรง ถ้าไม่ล็อกอิน
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>หน้าหลัก</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #686868ff);
            font-family: 'Sarabun', sans-serif;
        }
        .home-card {
            background: #fff;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            max-width: 600px;
            margin: auto;
            text-align: center;
        }
        .btn-secondary {
            border-radius: 30px;
            background-color: #ff3e3eff;
        }
    </style>
</head>
<body>
<div class="container my-5">
    <div class="home-card">
        <h1 class="mb-4">ยินดีต้อนรับสู่หน้าหลัก</h1>
        <p class="fs-5">ผู้ใช้: 
            <strong><?= htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8') ?></strong> 
            (<?= htmlspecialchars($_SESSION['role'], ENT_QUOTES, 'UTF-8') ?>)
        </p>
        <div class="mt-4">
            <a href="logout.php" class="btn btn-secondary btn-lg">ออกจากระบบ</a>
        </div>
    </div>
</div>
</body>
</html>
