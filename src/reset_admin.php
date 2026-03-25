<?php
session_start();

require_once __DIR__ . '/db.php';

$error = '';
$success = '';
$defaultUsername = 'admin';
$defaultPassword = 'Admin@12345';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? $defaultUsername);
    $newPassword = trim($_POST['password'] ?? $defaultPassword);

    if ($username === '' || $newPassword === '') {
        $error = 'กรุณากรอก username และรหัสผ่านใหม่';
    } else {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $findUser = $db->prepare('SELECT id FROM users WHERE name = :username LIMIT 1');
        $findUser->execute(['username' => $username]);
        $user = $findUser->fetch();

        if ($user) {
            $update = $db->prepare('UPDATE users SET password = :password, role = :role WHERE id = :id');
            $update->execute([
                'password' => $hashedPassword,
                'role' => 'admin',
                'id' => $user['id'],
            ]);
            $success = "รีเซ็ตรหัสผ่านของ {$username} เรียบร้อยแล้ว";
        } else {
            $email = $username . '@local.test';
            $insert = $db->prepare(
                'INSERT INTO users (name, email, password, role) VALUES (:username, :email, :password, :role)'
            );
            $insert->execute([
                'username' => $username,
                'email' => $email,
                'password' => $hashedPassword,
                'role' => 'admin',
            ]);
            $success = "สร้าง admin ใหม่ชื่อ {$username} เรียบร้อยแล้ว";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Admin Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-100 px-4 py-10">
    <div class="mx-auto max-w-xl rounded-2xl bg-white p-8 shadow-lg">
        <h1 class="text-2xl font-bold text-slate-900">Reset Admin Password</h1>
        <p class="mt-2 text-sm text-slate-600">
            ใช้หน้านี้สำหรับรีเซ็ตรหัสผ่านแอดมินในเครื่องนี้ชั่วคราว แล้วควรลบไฟล์นี้หลังใช้งานเสร็จ
        </p>

        <?php if ($error): ?>
            <div class="mt-4 rounded-xl bg-red-50 px-4 py-3 text-sm text-red-600">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="mt-4 rounded-xl bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                <?= htmlspecialchars($success) ?>
            </div>
            <div class="mt-3 rounded-xl bg-slate-100 px-4 py-3 text-sm text-slate-700">
                เข้าระบบด้วย Username: <strong><?= htmlspecialchars($_POST['username'] ?? $defaultUsername) ?></strong>
                และ Password: <strong><?= htmlspecialchars($_POST['password'] ?? $defaultPassword) ?></strong>
            </div>
        <?php endif; ?>

        <form class="mt-6 space-y-4" method="post">
            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Admin Username</label>
                <input class="w-full rounded-xl border border-slate-300 px-4 py-3" type="text" name="username" value="<?= htmlspecialchars($_POST['username'] ?? $defaultUsername) ?>">
            </div>

            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">New Password</label>
                <input class="w-full rounded-xl border border-slate-300 px-4 py-3" type="text" name="password" value="<?= htmlspecialchars($_POST['password'] ?? $defaultPassword) ?>">
            </div>

            <button class="w-full rounded-xl bg-indigo-600 px-4 py-3 font-semibold text-white" type="submit">
                Reset Password
            </button>
        </form>
    </div>
</body>
</html>
