<?php
session_start();

require_once '../core/auth.php';
require_once 'class.php';

requireRole('admin', '../index.php');

$account = new Account();
$displayName = $_SESSION['username'] ?? 'Admin';
$roleLabel = ucfirst($_SESSION['role'] ?? 'admin');
$isAdmin = true;
$activePage = 'accounts';
$basePath = '../';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'create') {
        $account->create($_POST['user_id'], $_POST['account_number'], $_POST['balance']);
    } elseif ($action === 'update') {
        $account->update($_POST['id'], $_POST['balance']);
    } elseif ($action === 'delete') {
        $account->delete($_POST['id']);
    }

    header('Location: index.php');
    exit;
}

$accounts = $account->getAll();
$users = $account->getUsers();
?>
<!DOCTYPE html>
<html class="light" lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Management</title>
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

        .modal {
            display: none;
        }

        .modal.show {
            display: flex;
        }
    </style>
</head>
<body class="bg-surface font-body text-text">
    <?php require __DIR__ . '/../includes/sidebar.php'; ?>

    <main class="ml-64 min-h-screen">
        <header class="sticky top-0 z-20 flex h-16 items-center justify-between bg-white/80 px-8 shadow-sm backdrop-blur">
            <div>
                <h2 class="text-xl font-bold">Account Management</h2>
                <p class="text-sm text-muted">ຈັດການບັນຊີຜູ້ໃຊ້</p>
            </div>
            <div class="text-right">
                <p class="text-sm font-bold"><?= htmlspecialchars($displayName) ?></p>
                <p class="text-xs uppercase tracking-[0.2em] text-muted"><?= htmlspecialchars($roleLabel) ?></p>
            </div>
        </header>

        <div class="space-y-8 p-8">
            <section class="rounded-2xl border border-stroke bg-panel p-6 shadow-sm">
                <h3 class="mb-4 text-lg font-bold">Create Account</h3>
                <form class="grid gap-4 md:grid-cols-2 xl:grid-cols-4" method="post">
                    <input type="hidden" name="action" value="create">
                    <select class="rounded-xl border-stroke" name="user_id" required>
                        <option value="">-- Select User --</option>
                        <?php foreach ($users as $user): ?>
                            <option value="<?= $user['id'] ?>"><?= htmlspecialchars($user['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input class="rounded-xl border-stroke" type="text" name="account_number" placeholder="Account Number" required>
                    <input class="rounded-xl border-stroke" type="number" name="balance" placeholder="Balance" step="0.01" required>
                    <button class="rounded-xl bg-primary px-4 py-3 font-semibold text-white" type="submit">Create Account</button>
                </form>
            </section>

            <section class="rounded-2xl border border-stroke bg-panel p-6 shadow-sm">
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
                                <?php foreach ($accounts as $row): ?>
                                    <tr class="rounded-2xl bg-[#fdfdff] shadow-sm">
                                        <td class="rounded-l-2xl px-4 py-4"><?= htmlspecialchars($row['id']) ?></td>
                                        <td class="px-4 py-4"><?= htmlspecialchars($row['account_number']) ?></td>
                                        <td class="px-4 py-4"><?= htmlspecialchars($row['name']) ?></td>
                                        <td class="px-4 py-4"><?= number_format($row['balance'], 2) ?></td>
                                        <td class="rounded-r-2xl px-4 py-4">
                                            <div class="flex gap-2">
                                                <button class="rounded-lg bg-success px-3 py-2 text-sm font-semibold text-white" type="button" onclick="editAccount(<?= $row['id'] ?>, '<?= $row['balance'] ?>')">Edit</button>
                                                <form method="post" onsubmit="return confirm('Delete this account?')">
                                                    <input type="hidden" name="action" value="delete">
                                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
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
    </main>

    <div id="editModal" class="modal fixed inset-0 z-50 items-center justify-center bg-black/50 p-4">
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
            <form class="space-y-4" method="post" id="updateForm">
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="id" id="updateId" value="">
                <input class="w-full rounded-xl border-stroke" type="number" name="balance" id="updateBalance" placeholder="Balance" step="0.01" required>
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
            document.getElementById('editModal').classList.add('show');
        }

        function closeModal() {
            document.getElementById('editModal').classList.remove('show');
            document.getElementById('updateForm').reset();
            document.getElementById('updateId').value = '';
        }

        window.onclick = function(event) {
            const modal = document.getElementById('editModal');
            if (event.target === modal) {
                closeModal();
            }
        };
    </script>
</body>
</html>
