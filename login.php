<?php
session_start();
require_once("config.php");

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usernameOrEmail = trim($_POST['username_or_email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($usernameOrEmail === '' || $password === '') {
        $error = "กรุณากรอกชื่อผู้ใช้หรือรหัสผ่าน";
    } else {
        $sql  = "SELECT * FROM users WHERE username = ? OR email = ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$usernameOrEmail, $usernameOrEmail]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id']  = $user['id'];        // ฟิลด์จริงใน DB
            $_SESSION['username'] = $user['username'];  // ฟิลด์จริงใน DB
            $_SESSION['role']     = $user['role'];      // ฟิลด์จริงใน DB

            if ($user['role'] === 'admin') {
                header("Location: admin/index.php");
            } else {
                header("Location: index.php");
            }
            exit;
        } else {
            $error = "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>เข้าสู่ระบบ</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
  body {
    background: linear-gradient(to right, #686868ff);
    font-family: 'Sarabun', sans-serif;
  }
  .login-card {
    background: #fff;
    border-radius: 20px;
    padding: 40px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    max-width: 500px;
    margin: auto;
  }
  .form-label {
    font-weight: bold;
  }
  .btn-success {
    border-radius: 30px;
  }
</style>
</head>
<body>
<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-lg-6">
      <div class="login-card">
        <h2 class="text-center mb-4">เข้าสู่ระบบ</h2>

        <?php if (isset($_GET['register']) && $_GET['register'] === 'success'): ?>
          <div class="alert alert-success">✅ สมัครสมาชิกสำเร็จ กรุณาเข้าสู่ระบบ</div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
          <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="post">
          <div class="mb-3">
            <label for="username_or_email" class="form-label">ชื่อผู้ใช้หรืออีเมล</label>
            <input type="text" class="form-control" id="username_or_email" name="username_or_email"
                   placeholder="กรอกชื่อผู้ใช้หรืออีเมล" required
                   value="<?= htmlspecialchars($_POST['username_or_email'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">รหัสผ่าน</label>
            <input type="password" class="form-control" id="password" name="password"
                   placeholder="กรอกรหัสผ่าน" required>
          </div>
          <div class="d-grid gap-2 mt-4">
            <button type="submit" class="btn btn-success btn-lg">เข้าสู่ระบบ</button>
            <a href="register.php" class="btn btn-outline-secondary">สมัครสมาชิก</a>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>
</body>
</html>
