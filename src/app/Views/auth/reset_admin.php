<div class="flex min-h-screen items-center justify-center px-4 py-10">
    <section class="w-full max-w-xl rounded-3xl border border-stroke bg-white p-8 shadow-lg">
        <h1 class="text-2xl font-bold">Reset Admin Password</h1>
        <p class="mt-2 text-sm text-muted">หน้ารีเซ็ตชั่วคราวสำหรับตั้งรหัส admin ใหม่ในเครื่องนี้</p>

        <?php if (!empty($error)): ?>
            <div class="mt-4 rounded-xl border border-danger/20 bg-danger/10 px-4 py-3 text-sm text-danger">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div class="mt-4 rounded-xl border border-success/20 bg-success/10 px-4 py-3 text-sm text-success">
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($credentials)): ?>
            <div class="mt-4 rounded-xl bg-slate-100 px-4 py-3 text-sm text-slate-700">
                Username: <strong><?= htmlspecialchars($credentials['username']) ?></strong>
                Password: <strong><?= htmlspecialchars($credentials['password']) ?></strong>
            </div>
        <?php endif; ?>

        <form class="mt-6 space-y-4" method="post" action="/reset-admin">
            <input class="w-full rounded-xl border border-stroke px-4 py-3" type="text" name="username" placeholder="Admin Username" value="admin">
            <input class="w-full rounded-xl border border-stroke px-4 py-3" type="text" name="password" placeholder="New Password" value="Admin@12345">
            <button class="w-full rounded-xl bg-primary px-4 py-3 font-semibold text-white" type="submit">Reset Password</button>
        </form>
    </section>
</div>
