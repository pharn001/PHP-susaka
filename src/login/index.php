<?php
session_start();

$error        = $_SESSION['login_error']    ?? '';
$lastUsername = $_SESSION['login_username'] ?? '';
unset($_SESSION['login_error'], $_SESSION['login_username']);
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>Login Page</h1>
    <?php if ($error): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form method="post" action="action.php">
        <input type="text" name="username" placeholder="Username"
               value="<?= htmlspecialchars($lastUsername) ?>">
        <input type="password" name="password" placeholder="Password">
        <button type="submit" name="submit" value="Login">Login</button>
        <a href="../register/index.php">Register here</a>
    </form>
</body>
</html>