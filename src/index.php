<?php
session_start();

require_once __DIR__ . '/core/auth.php';

requireLogin('login/index.php');

$displayName = $_SESSION['username'] ?? 'User';
$roleLabel = ucfirst($_SESSION['role'] ?? 'user');
$isAdmin = ($_SESSION['role'] ?? '') === 'admin';
$activePage = 'dashboard';
$basePath = '';
?>
<!DOCTYPE html>

<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Precision Intelligence Dashboard</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "tertiary-fixed": "#eaddff",
                        "on-tertiary-fixed-variant": "#5a00c6",
                        "on-surface": "#191c1e",
                        "on-primary-container": "#dad7ff",
                        "secondary-container": "#d5e0f8",
                        "on-tertiary": "#ffffff",
                        "error": "#ba1a1a",
                        "surface-bright": "#f7f9fb",
                        "on-tertiary-fixed": "#25005a",
                        "surface-container-highest": "#e0e3e5",
                        "on-background": "#191c1e",
                        "outline-variant": "#c7c4d8",
                        "inverse-primary": "#c3c0ff",
                        "tertiary-container": "#7531e6",
                        "on-secondary": "#ffffff",
                        "surface-container-low": "#f2f4f6",
                        "secondary-fixed": "#d8e3fb",
                        "on-primary-fixed": "#0f0069",
                        "surface-dim": "#d8dadc",
                        "surface": "#f7f9fb",
                        "primary-fixed-dim": "#c3c0ff",
                        "surface-container-high": "#e6e8ea",
                        "outline": "#777587",
                        "error-container": "#ffdad6",
                        "surface-variant": "#e0e3e5",
                        "surface-tint": "#4d44e3",
                        "on-secondary-fixed-variant": "#3c475a",
                        "primary-container": "#4f46e5",
                        "surface-container": "#eceef0",
                        "secondary-fixed-dim": "#bcc7de",
                        "on-secondary-container": "#586377",
                        "tertiary": "#5c00ca",
                        "on-error-container": "#93000a",
                        "on-tertiary-container": "#e4d4ff",
                        "surface-container-lowest": "#ffffff",
                        "tertiary-fixed-dim": "#d2bbff",
                        "secondary": "#545f73",
                        "primary-fixed": "#e2dfff",
                        "on-error": "#ffffff",
                        "inverse-on-surface": "#eff1f3",
                        "inverse-surface": "#2d3133",
                        "on-primary-fixed-variant": "#3323cc",
                        "on-primary": "#ffffff",
                        "on-secondary-fixed": "#111c2d",
                        "background": "#f7f9fb",
                        "primary": "#3525cd",
                        "on-surface-variant": "#464555"
                    },
                    fontFamily: {
                        "headline": ["Inter"],
                        "body": ["Inter"],
                        "label": ["Inter"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.125rem",
                        "lg": "0.25rem",
                        "xl": "0.5rem",
                        "full": "0.75rem"
                    },
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>

<body class="bg-surface font-body text-on-surface">
    <?php require __DIR__ . '/includes/sidebar.php'; ?>
    <!-- Main Content Wrapper -->
    <main class="ml-64 min-h-screen">
        <!-- TopAppBar (Blueprint Execution) -->
        <header class="flex items-center justify-between px-8 w-full h-16 sticky top-0 z-40 bg-white/80 backdrop-blur-md shadow-sm">
            <div class="flex items-center gap-6 flex-1">
                <div class="relative w-full max-w-md">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-lg">search</span>
                    <input class="w-full bg-surface-container-low border-none rounded-full py-2 pl-10 pr-4 text-sm focus:ring-2 focus:ring-primary/20 transition-all" placeholder="Search data points, users, or reports..." type="text" />
                </div>
            </div>
            <div class="flex items-center gap-4">
                <button class="w-10 h-10 flex items-center justify-center rounded-full text-on-surface-variant hover:bg-[#f2f4f6] transition-colors active:scale-95">
                    <span class="material-symbols-outlined">notifications</span>
                </button>
                <button class="w-10 h-10 flex items-center justify-center rounded-full text-on-surface-variant hover:bg-[#f2f4f6] transition-colors active:scale-95">
                    <span class="material-symbols-outlined">settings</span>
                </button>
                <div class="h-8 w-[1px] bg-outline-variant/20 mx-2"></div>
                <div class="flex items-center gap-3 pl-2 group cursor-pointer">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-bold text-on-surface"><?= htmlspecialchars($displayName) ?></p>
                        <p class="text-[10px] text-on-surface-variant font-semibold uppercase tracking-wider"><?= htmlspecialchars($roleLabel) ?></p>
                    </div>
                    <img alt="User profile avatar" class="w-10 h-10 rounded-full object-cover border-2 border-primary/10 group-hover:border-primary transition-all" data-alt="Professional portrait of a male executive in a clean studio setting with soft lighting" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCYy5NAsK9culYJ3Glaqk_koewEsseIO9q5bwfl2tscHMKZgFJnRLwX9epdZOhJEEXc6kuTE2lxheiWG9c7dIkTb6Z77iDXWi1RJ2LImdYhUWbnkaoAyFwjZv5_jBPn4f-C2R9al262SVoe9NuebCzoZJLVGuax7GsBprBLJNf-WnRjvFm9exE94Babt6xtJEfKxwwcc-r_4fpPCz6kBVDHbKjKsPk8EKi7IfbmObf-q6sAlJ4Lfx91RILV_RBiu_mBDxfbPjOc9XO0" />
                </div>
            </div>
        </header>
        <!-- Dashboard Canvas -->
        <div class="p-8 space-y-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <h2 class="text-3xl font-extrabold tracking-tight text-on-surface">Welcome back, <?= htmlspecialchars($displayName) ?></h2>
                    <p class="text-on-surface-variant mt-1 font-medium">Here's what's happening with Precision Intelligence today.</p>
                </div>
                <div class="bg-surface-container-low px-4 py-2 rounded-xl flex items-center gap-3 text-on-surface-variant border border-outline-variant/10">
                    <span class="material-symbols-outlined text-primary">calendar_today</span>
                    <span class="text-sm font-semibold">October 25, 2026</span>
                </div>
            </div>

            <section class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                <a class="rounded-2xl border border-outline-variant/20 bg-white p-6 shadow-sm transition-transform hover:-translate-y-1 hover:shadow-lg" href="index.php">
                    <div class="flex items-center justify-between">
                        <span class="material-symbols-outlined text-3xl text-primary">dashboard</span>
                        <span class="text-xs font-semibold uppercase tracking-[0.2em] text-on-surface-variant">Page</span>
                    </div>
                    <h3 class="mt-4 text-xl font-bold text-on-surface">Dashboard</h3>
                    <p class="mt-2 text-sm text-on-surface-variant">ພາບລວມຂອງລະບົບແລະທາງລັດ</p>
                </a>

                <?php if ($isAdmin): ?>
                    <a class="rounded-2xl border border-outline-variant/20 bg-white p-6 shadow-sm transition-transform hover:-translate-y-1 hover:shadow-lg" href="account/index.php">
                        <div class="flex items-center justify-between">
                            <span class="material-symbols-outlined text-3xl text-primary">account_balance</span>
                            <span class="text-xs font-semibold uppercase tracking-[0.2em] text-on-surface-variant">Admin</span>
                        </div>
                        <h3 class="mt-4 text-xl font-bold text-on-surface">Account Management</h3>
                        <p class="mt-2 text-sm text-on-surface-variant">ສ້າງ ແກ້ໄຂ ແລະ ລົບບັນຊີຜູ້ໃຊ້ຈາກຫນ້າດຽວ</p>
                    </a>

                    <a class="rounded-2xl border border-outline-variant/20 bg-white p-6 shadow-sm transition-transform hover:-translate-y-1 hover:shadow-lg" href="register/index.php">
                        <div class="flex items-center justify-between">
                            <span class="material-symbols-outlined text-3xl text-primary">person_add</span>
                            <span class="text-xs font-semibold uppercase tracking-[0.2em] text-on-surface-variant">Admin</span>
                        </div>
                        <h3 class="mt-4 text-xl font-bold text-on-surface">Register User</h3>
                        <p class="mt-2 text-sm text-on-surface-variant">ເພີ່ມຜູ້ໃຊ້ໃໝ່ເຂົ້າສູ່ລະບົບໂດຍຍັງຄົງບັນຫາ role ປົກກະຕິເປັນ user</p>
                    </a>
                <?php endif; ?>

                <a class="rounded-2xl border border-outline-variant/20 bg-white p-6 shadow-sm transition-transform hover:-translate-y-1 hover:shadow-lg" href="logout.php">
                    <div class="flex items-center justify-between">
                        <span class="material-symbols-outlined text-3xl text-primary">logout</span>
                        <span class="text-xs font-semibold uppercase tracking-[0.2em] text-on-surface-variant">Session</span>
                    </div>
                    <h3 class="mt-4 text-xl font-bold text-on-surface">Logout</h3>
                    <p class="mt-2 text-sm text-on-surface-variant">ອອກຈາກລະບົບ ແລະ ກັບໄປຫນ້າເຂົ້າສູ່ລະບົບ</p>
                </a>
            </section>
        </div>
    </main>
    <!-- Contextual FAB (Blueprint Command) -->
    <button class="fixed bottom-8 right-8 w-14 h-14 rounded-full bg-gradient-to-br from-[#3525cd] to-[#4f46e5] text-white shadow-2xl flex items-center justify-center group active:scale-90 transition-all z-50">
        <span class="material-symbols-outlined group-hover:rotate-90 transition-transform">add</span>
    </button>
</body>

</html>
