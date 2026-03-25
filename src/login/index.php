<?php
session_start();

require_once '../core/auth.php';

if (isLoggedIn()) {
    header('Location: ../index.php');
    exit;
}

$error        = $_SESSION['login_error']    ?? '';
$lastUsername = $_SESSION['login_username'] ?? '';
unset($_SESSION['login_error'], $_SESSION['login_username']);
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;500;600&family=Prompt:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Sarabun', sans-serif; }
        h1, .brand { font-family: 'Prompt', sans-serif; }

        .mesh-bg {
            background-color: #0f172a;
            background-image:
                radial-gradient(ellipse 80% 60% at 20% 10%, rgba(99,102,241,0.25) 0%, transparent 60%),
                radial-gradient(ellipse 60% 50% at 80% 80%, rgba(14,165,233,0.18) 0%, transparent 55%),
                radial-gradient(ellipse 40% 40% at 60% 30%, rgba(168,85,247,0.12) 0%, transparent 50%);
        }

        .glass-card {
            background: rgba(255,255,255,0.04);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255,255,255,0.09);
            box-shadow:
                0 0 0 1px rgba(99,102,241,0.08),
                0 32px 64px -16px rgba(0,0,0,0.6),
                inset 0 1px 0 rgba(255,255,255,0.08);
        }

        .input-field {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            color: #e2e8f0;
            transition: all 0.25s ease;
        }
        .input-field::placeholder { color: rgba(148,163,184,0.5); }
        .input-field:focus {
            outline: none;
            background: rgba(255,255,255,0.08);
            border-color: rgba(99,102,241,0.6);
            box-shadow: 0 0 0 3px rgba(99,102,241,0.15);
        }

        .btn-primary {
            background: linear-gradient(135deg, #6366f1 0%, #818cf8 100%);
            box-shadow: 0 4px 20px rgba(99,102,241,0.4), inset 0 1px 0 rgba(255,255,255,0.15);
            transition: all 0.25s ease;
        }
        .btn-primary:hover {
            box-shadow: 0 8px 28px rgba(99,102,241,0.55), inset 0 1px 0 rgba(255,255,255,0.2);
            transform: translateY(-1px);
        }
        .btn-primary:active { transform: translateY(0); }

        .decor-dot {
            background: radial-gradient(circle, rgba(99,102,241,0.5) 0%, transparent 70%);
            filter: blur(32px);
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeup { animation: fadeUp 0.6s ease both; }
        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.3s; }
        .delay-4 { animation-delay: 0.4s; }
    </style>
</head>
<body class="mesh-bg min-h-screen flex items-center justify-center p-4 overflow-hidden">

    <!-- Decorative blobs -->
    <div class="decor-dot absolute w-96 h-96 top-[-80px] left-[-80px] pointer-events-none"></div>
    <div class="decor-dot absolute w-80 h-80 bottom-[-60px] right-[-60px] pointer-events-none" style="background:radial-gradient(circle,rgba(14,165,233,0.4) 0%,transparent 70%);"></div>

    <div class="w-full max-w-md relative z-10">

        <!-- Brand -->
        <div class="text-center mb-8 animate-fadeup">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl mb-4"
                 style="background:linear-gradient(135deg,#6366f1,#818cf8);box-shadow:0 8px 24px rgba(99,102,241,0.4)">
                <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-white tracking-tight brand">ຍິນດີຕ້ອນຮັບ</h1>
            <p class="text-slate-400 text-sm mt-1 font-light">ກະລຸນາເຂົ້າສູ່ລະບົບເພື່ອດຳເນີນການຕໍ່</p>
        </div>

        <!-- Card -->
        <div class="glass-card rounded-3xl p-8">

            <!-- Error -->
            <?php if ($error): ?>
            <div class="flex items-start gap-3 bg-red-500/10 border border-red-500/25 rounded-xl px-4 py-3 mb-6 animate-fadeup">
                <svg class="w-4 h-4 text-red-400 mt-0.5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-9V5a1 1 0 112 0v4a1 1 0 11-2 0zm1 6a1.25 1.25 0 110-2.5 1.25 1.25 0 010 2.5z" clip-rule="evenodd"/>
                </svg>
                <p class="text-red-400 text-sm"><?= htmlspecialchars($error) ?></p>
            </div>
            <?php endif; ?>

            <form method="post" action="action.php" class="space-y-5">

                <!-- Username -->
                <div class="animate-fadeup delay-1">
                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-widest mb-2">
                        ຊື່ຜູ້ໃຊ້
                    </label>
                    <div class="relative">
                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-500">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0"/>
                            </svg>
                        </span>
                        <input
                            type="text"
                            name="username"
                            placeholder="ກະລຸນາໃສ່ຊື່ຜູ້ໃຊ້"
                            value="<?= htmlspecialchars($lastUsername) ?>"
                            class="input-field w-full rounded-xl pl-10 pr-4 py-3 text-sm"
                        >
                    </div>
                </div>

                <!-- Password -->
                <div class="animate-fadeup delay-2">
                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-widest mb-2">
                        ລະຫັດຜ່ານ
                    </label>
                    <div class="relative">
                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-500">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                            </svg>
                        </span>
                        <input
                            type="password"
                            name="password"
                            placeholder="ກະລຸນາໃສ່ລະຫັດຜ່ານ"
                            id="passwordInput"
                            class="input-field w-full rounded-xl pl-10 pr-11 py-3 text-sm"
                        >
                        <button type="button" onclick="togglePassword()"
                                class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-500 hover:text-slate-300 transition-colors">
                            <svg id="eyeIcon" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Submit -->
                <div class="animate-fadeup delay-3 pt-1">
                    <button type="submit" name="submit" value="Login"
                            class="btn-primary w-full rounded-xl py-3 text-white font-semibold text-sm tracking-wide">
                        ເຂົ້າສູ່ລະບົບ
                    </button>
                </div>

            </form>

            <!-- Register link -->
            <p class="text-center text-slate-500 text-sm mt-6 animate-fadeup delay-4">
                ຍັງບໍ່ມີບັນຊີ?
                <a href="../register/index.php"
                   class="text-indigo-400 hover:text-indigo-300 font-semibold transition-colors ml-1">
                    ສະໝັກຊະມາຊິກ
                </a>
            </p>
        </div>

        <p class="text-center text-slate-700 text-xs mt-6">© <?= date('Y') ?> All rights reserved.</p>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('passwordInput');
            const icon  = document.getElementById('eyeIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/>`;
            } else {
                input.type = 'password';
                icon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>`;
            }
        }
    </script>
</body>
</html>