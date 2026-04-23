<header class="sticky top-0 z-20 flex h-16 items-center justify-between bg-white/80 px-8 shadow-sm backdrop-blur">
    <div>
        <h2 class="text-xl font-bold">ໜ້າຫຼັກ</h2>
        <p class="text-sm text-muted">ພາບລວມຂອງລະບົບ ແລະ ທາງລັດໄປຫາໜ້າສຳຄັນ</p>
    </div>
    <div class="text-right">
        <p class="text-sm font-bold"><?= htmlspecialchars($user['username']) ?></p>
        <p class="text-xs uppercase tracking-[0.2em] text-muted"><?= htmlspecialchars(ucfirst($user['role'])) ?></p>
    </div>
</header>

<div class="space-y-8 p-8">
    <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight">ຍິນດີຕ້ອນຮັບ, <?= htmlspecialchars($user['username']) ?></h1>
            <p class="mt-1 text-muted">ເລືອກໜ້າທີ່ຕ້ອງການໃຊ້ງານຈາກເມນູ ຫຼື ກາດດ້ານລຸ່ມ</p>
        </div>
        <div class="rounded-xl border border-stroke bg-white px-4 py-2 text-sm font-semibold text-muted">
            <?= htmlspecialchars(date('F j, Y')) ?>
        </div>
    </div>

    <section class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
        <a class="rounded-2xl border border-stroke bg-white p-6 shadow-sm transition-transform hover:-translate-y-1 hover:shadow-lg" href="/">
            <div class="flex items-center justify-between">
                <span class="material-symbols-outlined text-3xl text-primary">dashboard</span>
                <span class="text-xs font-semibold uppercase tracking-[0.2em] text-muted">ໜ້າ</span>
            </div>
            <h3 class="mt-4 text-xl font-bold">ໜ້າຫຼັກ</h3>
            <p class="mt-2 text-sm text-muted">ພາບລວມຂອງລະບົບ ແລະ ລິ້ງໄປຫາໜ້າຫຼັກຂອງແອັບ</p>
        </a>

        <?php if ($isAdmin): ?>
            <a class="rounded-2xl border border-stroke bg-white p-6 shadow-sm transition-transform hover:-translate-y-1 hover:shadow-lg" href="/accounts">
                <div class="flex items-center justify-between">
                    <span class="material-symbols-outlined text-3xl text-primary">account_balance</span>
                    <span class="text-xs font-semibold uppercase tracking-[0.2em] text-muted">Admin</span>
                </div>
                <h3 class="mt-4 text-xl font-bold">ຈັດການບັນຊີ</h3>
                <p class="mt-2 text-sm text-muted">ສ້າງ, ແກ້ໄຂ ແລະ ລຶບບັນຊີຜູ້ໃຊ້ຈາກໜ້າດຽວ</p>
            </a>

            <a class="rounded-2xl border border-stroke bg-white p-6 shadow-sm transition-transform hover:-translate-y-1 hover:shadow-lg" href="/register">
                <div class="flex items-center justify-between">
                    <span class="material-symbols-outlined text-3xl text-primary">person_add</span>
                    <span class="text-xs font-semibold uppercase tracking-[0.2em] text-muted">Admin</span>
                </div>
                <h3 class="mt-4 text-xl font-bold">ເພີ່ມຜູ້ໃຊ້</h3>
                <p class="mt-2 text-sm text-muted">ເພີ່ມຜູ້ໃຊ້ໃໝ່ເຂົ້າລະບົບໃນ flow ດຽວກັນກັບ router ຫຼັກ</p>
            </a>
        <?php endif; ?>

        <a class="rounded-2xl border border-stroke bg-white p-6 shadow-sm transition-transform hover:-translate-y-1 hover:shadow-lg" href="/logout">
            <div class="flex items-center justify-between">
                <span class="material-symbols-outlined text-3xl text-primary">logout</span>
                <span class="text-xs font-semibold uppercase tracking-[0.2em] text-muted">ເຊສຊັນ</span>
            </div>
            <h3 class="mt-4 text-xl font-bold">ອອກຈາກລະບົບ</h3>
            <p class="mt-2 text-sm text-muted">ອອກຈາກລະບົບ ແລະ ກັບໄປຫາໜ້າເຂົ້າລະບົບ</p>
        </a>
    </section>
</div>
