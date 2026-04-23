<header class="sticky top-0 z-20 flex h-16 items-center justify-between bg-white/80 px-8 shadow-sm backdrop-blur">
    <div>
        <h2 class="text-xl font-bold">Account Management</h2>
        <p class="text-sm text-muted">จัดการบัญชีผู้ใช้จากหน้าหลักเดียว</p>
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
        <h3 class="mb-4 text-lg font-bold">Create Account</h3>
        <form class="grid gap-4 md:grid-cols-2 xl:grid-cols-4" method="post" action="/accounts">
            <select class="rounded-xl border border-stroke px-4 py-3" name="user_id" required>
                <option value="">-- Select User --</option>
                <?php foreach ($users as $accountUser): ?>
                    <option value="<?= $accountUser['id'] ?>"><?= htmlspecialchars($accountUser['name']) ?></option>
                <?php endforeach; ?>
            </select>
            <input class="rounded-xl border border-stroke px-4 py-3" type="text" name="account_number" placeholder="Account Number" required>
            <input class="rounded-xl border border-stroke px-4 py-3" type="number" name="balance" placeholder="Balance" step="0.01" required>
            <button class="rounded-xl bg-primary px-4 py-3 font-semibold text-white" type="submit">Create Account</button>
        </form>
    </section>

    <section class="rounded-2xl border border-stroke bg-white p-6 shadow-sm">
        <div class="mb-4 flex items-center justify-between">
            <h3 class="text-lg font-bold">Account List</h3>
            <span class="text-sm text-muted"><?= count($accounts) ?> records</span>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full border-separate border-spacing-y-3">
                <thead>
                    <tr class="text-left text-sm uppercase tracking-[0.15em] text-muted">
                        <th class="px-4">ID</th>
                        <th class="px-4">Account Number</th>
                        <th class="px-4">User Name</th>
                        <th class="px-4">Balance</th>
                        <th class="px-4">Action</th>
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
                                        <button class="rounded-lg bg-success px-3 py-2 text-sm font-semibold text-white" type="button" onclick="editAccount(<?= (int) $account['id'] ?>, '<?= htmlspecialchars((string) $account['balance'], ENT_QUOTES) ?>')">Edit</button>
                                        <form method="post" action="/accounts/delete" onsubmit="return confirm('Delete this account?')">
                                            <input type="hidden" name="id" value="<?= (int) $account['id'] ?>">
                                            <button class="rounded-lg bg-danger px-3 py-2 text-sm font-semibold text-white" type="submit">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td class="px-4 py-8 text-center text-muted" colspan="5">No accounts found</td>
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
                <h3 class="text-lg font-bold">Edit Account</h3>
                <p class="text-sm text-muted">Account ID: <strong id="accountIdDisplay"></strong></p>
            </div>
            <button class="text-muted" type="button" onclick="closeModal()">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <form class="space-y-4" method="post" action="/accounts/update" id="updateForm">
            <input type="hidden" name="id" id="updateId" value="">
            <input class="w-full rounded-xl border border-stroke px-4 py-3" type="number" name="balance" id="updateBalance" placeholder="Balance" step="0.01" required>
            <div class="flex gap-3">
                <button class="flex-1 rounded-xl bg-primary px-4 py-3 font-semibold text-white" type="submit">Update Balance</button>
                <button class="flex-1 rounded-xl border border-stroke px-4 py-3 font-semibold text-text" type="button" onclick="closeModal()">Cancel</button>
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
