<?php
session_start();
require_once 'db.php';
require_once 'core/auth.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? 'user';

    if (empty($username) || empty($email) || empty($password)) {
        $error = 'กรุณากรอก Username, Email และ Password';
    } else {
        $auth = new Auth($db);
        if ($auth->register($username, $email, $password, $role)) {
            $success = 'สมัครสมาชิกสำเร็จ';
        } else {
            $error = 'เกิดข้อผิดพลาด กรุณาลองใหม่';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <h1>Register Page</h1>
    <?php if ($error): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <?php if ($success): ?>
        <p style="color: green;"><?= htmlspecialchars($success) ?></p>
    <?php endif; ?>
    <form method="post">
        <input type="text" name="username" placeholder="Username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
        <input type="email" name="email" placeholder="Email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
        <input type="password" name="password" placeholder="Password">
        <select name="role" id="role">
            <option value="admin">Admin</option>
            <option value="user">User</option>
        </select>
        <button type="submit" name="submit" value="Register">Register</button>
        <a href="login.php">Login here</a>
    </form>
</body>
</html>
