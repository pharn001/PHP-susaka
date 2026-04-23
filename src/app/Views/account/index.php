<header class="sticky top-0 z-20 flex h-16 items-center justify-between bg-white/80 px-8 shadow-sm backdrop-blur">
    <div>
        <h2 class="text-xl font-bold">ຈັດການບັນຊີ</h2>
        <p class="text-sm text-muted">ຈັດການບັນຊີຜູ້ໃຊ້ຈາກໜ້າດຽວ</p>
    </div>
    <div class="text-right">
        <p class="text-sm font-bold"><?= htmlspecialchars($user['username']) ?></p>
        <p class="text-xs uppercase tracking-[0.2em] text-muted"><?= htmlspecialchars(ucfirst($user['role'])) ?></p>
    </div>
</header>

<div class="space-y-8 p-8">
    <?php if (!empty($error)): ?>
        <div class="rounded-xl border border-danger/20 bg-danger/10 px-4 py-3 text-sm text-danger">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <section class="rounded-2xl border border-stroke bg-white p-6 shadow-sm">
        <h3 class="mb-4 text-lg font-bold">ສ້າງບັນຊີ</h3>
        <form class="grid gap-4 md:grid-cols-2 xl:grid-cols-4" method="post" action="/accounts">
            <select class="rounded-xl border border-stroke px-4 py-3" name="user_id" required>
                <option value="">-- ເລືອກຜູ້ໃຊ້ --</option>
                <?php foreach ($users as $accountUser): ?>
                    <option value="<?= $accountUser['id'] ?>"><?= htmlspecialchars($accountUser['name']) ?></option>
                <?php endforeach; ?>
            </select>
            <input class="rounded-xl border border-stroke px-4 py-3" type="text" name="account_number" placeholder="ເລກບັນຊີ" required>
            <input class="rounded-xl border border-stroke px-4 py-3" type="number" name="balance" placeholder="ຍອດເງິນ" step="0.01" required>
            <button class="rounded-xl bg-primary px-4 py-3 font-semibold text-white" type="submit">ສ້າງບັນຊີ</button>
        </form>
    </section>

    <section class="rounded-2xl border border-stroke bg-white p-6 shadow-sm">
        <div class="mb-4 flex items-center justify-between">
            <h3 class="text-lg font-bold">ລາຍການບັນຊີ</h3>
            <span class="text-sm text-muted"><?= count($accounts) ?> ລາຍການ</span>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full border-separate border-spacing-y-3">
                <thead>
                    <tr class="text-left text-sm uppercase tracking-[0.15em] text-muted">
                        <th class="px-4">ID</th>
                        <th class="px-4">ເລກບັນຊີ</th>
                        <th class="px-4">ຊື່ຜູ້ໃຊ້</th>
                        <th class="px-4">ຍອດເງິນ</th>
                        <th class="px-4">ຈັດການ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($accounts): ?>
                        <?php foreach ($accounts as $account): ?>
                            <tr class="bg-[#fdfdff] shadow-sm">
                                <td class="rounded-l-2xl px-4 py-4"><?= htmlspecialchars($account['id']) ?></td>
                                <td class="px-4 py-4"><?= htmlspecialchars($account['account_number']) ?></td>
                                <td class="px-4 py-4"><?= htmlspecialchars($account['name']) ?></td>
                                <td class="px-4 py-4"><?= number_format((float) $account['balance'], 2) ?></td>
                                <td class="rounded-r-2xl px-4 py-4">
                                    <div class="flex gap-2">
                                        <button class="rounded-lg bg-success px-3 py-2 text-sm font-semibold text-white" type="button" onclick="editAccount(<?= (int) $account['id'] ?>, '<?= htmlspecialchars((string) $account['balance'], ENT_QUOTES) ?>')">ແກ້ໄຂ</button>
                                        <form method="post" action="/accounts/delete" onsubmit="return confirm('ຕ້ອງການລຶບບັນຊີນີ້ບໍ?')">
                                            <input type="hidden" name="id" value="<?= (int) $account['id'] ?>">
                                            <button class="rounded-lg bg-danger px-3 py-2 text-sm font-semibold text-white" type="submit">ລຶບ</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td class="px-4 py-8 text-center text-muted" colspan="5">ບໍ່ພົບຂໍ້ມູນບັນຊີ</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</div>

<div id="editModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4">
        <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-xl">
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold">ແກ້ໄຂບັນຊີ</h3>
                    <p class="text-sm text-muted">ID ບັນຊີ: <strong id="accountIdDisplay"></strong></p>
                </div>
            <button class="text-muted" type="button" onclick="closeModal()">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <form class="space-y-4" method="post" action="/accounts/update" id="updateForm">
            <input type="hidden" name="id" id="updateId" value="">
            <input class="w-full rounded-xl border border-stroke px-4 py-3" type="number" name="balance" id="updateBalance" placeholder="ຍອດເງິນ" step="0.01" required>
            <div class="flex gap-3">
                <button class="flex-1 rounded-xl bg-primary px-4 py-3 font-semibold text-white" type="submit">ບັນທຶກຍອດເງິນ</button>
                <button class="flex-1 rounded-xl border border-stroke px-4 py-3 font-semibold text-text" type="button" onclick="closeModal()">ຍົກເລີກ</button>
            </div>
        </form>
    </div>
</div>

<script>
    function editAccount(id, balance) {
        document.getElementById('updateId').value = id;
        document.getElementById('updateBalance').value = balance;
        document.getElementById('accountIdDisplay').textContent = id;
        document.getElementById('editModal').classList.remove('hidden');
        document.getElementById('editModal').classList.add('flex');
    }

    function closeModal() {
        document.getElementById('editModal').classList.add('hidden');
        document.getElementById('editModal').classList.remove('flex');
        document.getElementById('updateForm').reset();
    }

    window.addEventListener('click', function(event) {
        const modal = document.getElementById('editModal');
        if (event.target === modal) {
            closeModal();
        }
    });
</script>
