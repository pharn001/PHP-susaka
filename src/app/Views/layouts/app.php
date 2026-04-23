<?php
$title = $title ?? 'App';
$layoutMode = $layoutMode ?? 'app';
$user = $user ?? AuthService::user();
$activePage = $activePage ?? 'dashboard';
$isAdmin = $isAdmin ?? AuthService::isAdmin();
?>
<!DOCTYPE html>
<html class="light" lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
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
    <?php if ($layoutMode !== 'guest'): ?>
        <?php require __DIR__ . '/../partials/sidebar.php'; ?>
    <?php endif; ?>

    <main class="<?= $layoutMode === 'guest' ? 'min-h-screen' : 'ml-64 min-h-screen' ?>">
        <?= $content ?>
    </main>
</body>
</html>
