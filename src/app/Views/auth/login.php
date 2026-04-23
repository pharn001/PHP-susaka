<div class="flex min-h-screen items-center justify-center px-4 py-10">
    <section class="w-full max-w-md rounded-3xl border border-stroke bg-white p-8 shadow-lg">
        <h1 class="text-3xl font-black text-text">Login</h1>
        <p class="mt-2 text-sm text-muted">เข้าสู่ระบบผ่าน front controller และ router กลางของโปรเจ็กต์</p>

        <?php if (!empty($error)): ?>
            <div class="mt-4 rounded-xl border border-danger/20 bg-danger/10 px-4 py-3 text-sm text-danger">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form class="mt-6 space-y-4" method="post" action="/login">
            <input class="w-full rounded-xl border border-stroke px-4 py-3" type="text" name="username" placeholder="Username" value="<?= htmlspecialchars($old['username'] ?? '') ?>">
            <input class="w-full rounded-xl border border-stroke px-4 py-3" type="password" name="password" placeholder="Password">
            <button class="w-full rounded-xl bg-primary px-4 py-3 font-semibold text-white" type="submit">Login</button>
        </form>

        <div class="mt-6 flex justify-between text-sm">
            <a class="font-semibold text-primary" href="/reset-admin">Reset admin password</a>
            <a class="font-semibold text-primary" href="/">Back home</a>
        </div>
    </section>
</div>
