<?php
$navItemClass = 'flex items-center gap-3 rounded-lg px-4 py-3 text-[#464555] transition-all hover:bg-white hover:text-[#3525cd]';
$activeNavItemClass = 'flex items-center gap-3 rounded-lg bg-white px-4 py-3 font-bold text-[#3525cd]';
?>
<aside class="fixed left-0 top-0 z-50 flex h-screen w-64 flex-col bg-[#f2f4f6] px-4 py-6">
    <div class="mb-10 flex items-center gap-3 px-2">
        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#3525cd] text-white">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">precision_manufacturing</span>
        </div>
        <div>
            <h1 class="text-lg font-black uppercase tracking-tight text-[#3525cd]">Intelligence</h1>
            <p class="text-[10px] uppercase tracking-[0.2em] text-[#464555] opacity-60">Management v1.0</p>
        </div>
    </div>

    <nav class="flex-1 space-y-2">
        <a class="<?= $activePage === 'dashboard' ? $activeNavItemClass : $navItemClass ?>" href="/">
            <span class="material-symbols-outlined">dashboard</span>
            <span class="text-sm">ໜ້າຫຼັກ</span>
        </a>

        <?php if ($isAdmin): ?>
            <a class="<?= $activePage === 'accounts' ? $activeNavItemClass : $navItemClass ?>" href="/accounts">
                <span class="material-symbols-outlined">account_balance</span>
                <span class="text-sm">ບັນຊີ</span>
            </a>
            <a class="<?= $activePage === 'register' ? $activeNavItemClass : $navItemClass ?>" href="/register">
                <span class="material-symbols-outlined">person_add</span>
                <span class="text-sm">ເພີ່ມຜູ້ໃຊ້</span>
            </a>
        <?php endif; ?>
    </nav>

    <a class="mt-auto flex items-center gap-3 rounded-lg px-4 py-3 text-[#464555] transition-all hover:bg-white hover:text-[#3525cd]" href="/logout">
        <span class="material-symbols-outlined">logout</span>
        <span class="text-sm font-semibold">ອອກຈາກລະບົບ</span>
    </a>
</aside>
