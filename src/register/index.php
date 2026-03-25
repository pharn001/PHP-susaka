<?php
session_start();

require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../core/auth.php';

if (isLoggedIn() && ($_SESSION['role'] ?? '') !== 'admin') {
    header('Location: ../index.php');
    exit;
}

$error = '';
$success = '';
$displayName = $_SESSION['username'] ?? 'Admin';
$roleLabel = ucfirst($_SESSION['role'] ?? 'admin');
$isAdmin = ($_SESSION['role'] ?? '') === 'admin';
$activePage = 'register';
$basePath = '../';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $email === '' || $password === '') {
        $error = 'กรุณากรอก Username, Email และ Password';
    } else {
        $auth = new Auth($db);

        try {
            if ($auth->register($username, $email, $password)) {
                $success = 'สมัครสมาชิกสำเร็จ';
            }
        } catch (RuntimeException $exception) {
            $error = $exception->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html class="light" lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: "#3525cd",
                        surface: "#f7f9fb",
                        panel: "#ffffff",
                        stroke: "#dfe3ea",
                        text: "#191c1e",
                        muted: "#667085",
                        danger: "#dc3545",
                        success: "#28a745"
                    },
                    fontFamily: {
                        body: ["Inter", "sans-serif"]
                    }
                }
            }
        };
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>
<body class="bg-surface font-body text-text">
    <?php require __DIR__ . '/../includes/sidebar.php'; ?>

    <main class="ml-64 min-h-screen">
        <header class="sticky top-0 z-20 flex h-16 items-center justify-between bg-white/80 px-8 shadow-sm backdrop-blur">
            <div>
                <h2 class="text-xl font-bold">Register User</h2>
                <p class="text-sm text-muted">ເພີ່ມຜູ້ໃຊ້</p>
            </div>
            <div class="text-right">
                <p class="text-sm font-bold"><?= htmlspecialchars($displayName) ?></p>
                <p class="text-xs uppercase tracking-[0.2em] text-muted"><?= htmlspecialchars($roleLabel) ?></p>
            </div>
        </header>

        <div class="p-8">
            <section class="mx-auto max-w-2xl rounded-2xl border border-stroke bg-panel p-8 shadow-sm">
                <h3 class="mb-6 text-2xl font-bold">Create New User</h3>

                <?php if ($error): ?>
                    <div class="mb-4 rounded-xl border border-danger/20 bg-danger/10 px-4 py-3 text-sm text-danger">
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <?php if ($success): ?>
                    <div class="mb-4 rounded-xl border border-success/20 bg-success/10 px-4 py-3 text-sm text-success">
                        <?= htmlspecialchars($success) ?>
                    </div>
                <?php endif; ?>

                <form class="space-y-4" method="post">
                    <input class="w-full rounded-xl border-stroke" type="text" name="username" placeholder="Username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
                    <input class="w-full rounded-xl border-stroke" type="email" name="email" placeholder="Email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                    <input class="w-full rounded-xl border-stroke" type="password" name="password" placeholder="Password">
                    <button class="w-full rounded-xl bg-primary px-4 py-3 font-semibold text-white" type="submit" name="submit" value="Register">Register</button>
                </form>
            </section>
        </div>
    </main>
</body>
</html>
