<header class="sticky top-0 z-20 flex h-16 items-center justify-between bg-white/80 px-8 shadow-sm backdrop-blur">
    <div>
        <h2 class="text-xl font-bold">ເພີ່ມຜູ້ໃຊ້</h2>
        <p class="text-sm text-muted">ເພີ່ມຜູ້ໃຊ້ໃໝ່ເຂົ້າໃຊ້ລະບົບ</p>
    </div>
    <div class="text-right">
        <p class="text-sm font-bold"><?= htmlspecialchars($user['username']) ?></p>
        <p class="text-xs uppercase tracking-[0.2em] text-muted"><?= htmlspecialchars(ucfirst($user['role'])) ?></p>
    </div>
</header>

<div class="p-8">
    <section class="mx-auto max-w-2xl rounded-2xl border border-stroke bg-white p-8 shadow-sm">
        <h3 class="mb-6 text-2xl font-bold">ສ້າງຜູ້ໃຊ້ໃໝ່</h3>

        <?php if (!empty($error)): ?>
            <div class="mb-4 rounded-xl border border-danger/20 bg-danger/10 px-4 py-3 text-sm text-danger">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div class="mb-4 rounded-xl border border-success/20 bg-success/10 px-4 py-3 text-sm text-success">
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>

        <form class="space-y-4" method="post" action="/register">
            <input class="w-full rounded-xl border border-stroke px-4 py-3" type="text" name="username" placeholder="ຊື່ຜູ້ໃຊ້" value="<?= htmlspecialchars($old['username'] ?? '') ?>">
            <input class="w-full rounded-xl border border-stroke px-4 py-3" type="email" name="email" placeholder="ອີເມວ" value="<?= htmlspecialchars($old['email'] ?? '') ?>">
            <input class="w-full rounded-xl border border-stroke px-4 py-3" type="password" name="password" placeholder="ລະຫັດຜ່ານ">
            <button class="w-full rounded-xl bg-primary px-4 py-3 font-semibold text-white" type="submit">ບັນທຶກ</button>
        </form>
    </section>
</div>
