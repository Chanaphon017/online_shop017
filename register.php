<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $fname = trim($_POST['fname']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    if ($password === $cpassword) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users(username, full_name, email, password, role) VALUES (?, ?, ?, ?, 'admin')";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$username, $fname, $email, $hashedPassword]);
    } else {
        echo "<script>alert('รหัสผ่านไม่ตรงกัน');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>สมัครสมาชิก</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Sarabun', sans-serif;
    }
    .register-card {
      background: white;
      padding: 20px;
    }
    .form-label {
      font-weight: bold;
    }
  </style>
</head>
<body>

  <div class="container my-5">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="register-card">
          <h2 class="text-center mb-4">สมัครสมาชิก</h2>
          <form method="post" action="">
            <div class="row g-3">
              <div class="col-md-6">
                <label for="username" class="form-label">ชื่อผู้ใช้</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="ชื่อผู้ใช้" required>
              </div>
              <div class="col-md-6">
                <label for="fname" class="form-label">ชื่อ - นามสกุล</label>
                <input type="text" class="form-control" id="fname" name="fname" placeholder="ชื่อ - นามสกุล" required>
              </div>
              <div class="col-md-6">
                <label for="email" class="form-label">อีเมล</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="example@email.com" required>
              </div>
              <div class="col-md-6">
                <label for="password" class="form-label">รหัสผ่าน</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="รหัสผ่าน" required>
              </div>
              <div class="col-md-6">
                <label for="cpassword" class="form-label">ยืนยันรหัสผ่าน</label>
                <input type="password" class="form-control" id="cpassword" name="cpassword" placeholder="ยืนยันรหัสผ่าน" required>
              </div>
            </div>
            <div class="d-grid gap-2 mt-4">
              <button type="submit" class="btn btn-primary btn-lg">สมัครสมาชิก</button>
              <a href="login.php" class="btn btn-outline-secondary">กลับไปหน้าล็อกอิน</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

</body>
</html>