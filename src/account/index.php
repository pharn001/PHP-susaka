<?php
require_once 'class.php';
$account = new Account();

// Handle POST actions
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
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        .form-section {
            background: #f5f5f5;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 30px;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 10px;
            max-width: 500px;
        }
        input, select {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            padding: 10px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background: #0056b3;
        }
        button.delete {
            background: #dc3545;
        }
        button.delete:hover {
            background: #c82333;
        }
        button.edit {
            background: #28a745;
            padding: 5px 10px;
        }
        button.edit:hover {
            background: #218838;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background: #f9f9f9;
        }
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }
        .modal.show {
            display: block;
        }
        .modal-content {
            background-color: white;
            margin: 10% auto;
            padding: 30px;
            border-radius: 8px;
            width: 90%;
            max-width: 400px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }
        .close-btn {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            line-height: 20px;
        }
        .close-btn:hover {
            color: #000;
        }
        .modal-header {
            margin-bottom: 20px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }
        .modal-header h2 {
            margin: 0;
            color: #007bff;
        }
        .modal form {
            max-width: none;
        }
        .modal-buttons {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }
        .modal-buttons button {
            flex: 1;
        }
        .modal-buttons button.cancel {
            background: #6c757d;
        }
        .modal-buttons button.cancel:hover {
            background: #5a6268;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Account Management</h1>
        
        <!-- Create Form -->
        <div class="form-section">
            <h2>Create Account</h2>
            <form method="post">
                <input type="hidden" name="action" value="create">
                <select name="user_id" required>
                    <option value="">-- Select User --</option>
                    <?php foreach ($users as $user): ?>
                        <option value="<?= $user['id'] ?>"><?= htmlspecialchars($user['name']) ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="text" name="account_number" placeholder="Account Number" required>
                <input type="number" name="balance" placeholder="Balance" step="0.01" required>
                <button type="submit">Create Account</button>
            </form>
        </div>

        <!-- Edit Modal -->
        <div id="editModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="close-btn" onclick="closeModal()">&times;</span>
                    <h2>Edit Account</h2>
                </div>
                <form method="post" id="updateForm">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="id" id="updateId" value="">
                    <div>
                        <label>Account ID: <strong id="accountIdDisplay"></strong></label>
                    </div>
                    <input type="number" name="balance" id="updateBalance" placeholder="Balance" step="0.01" required>
                    <div class="modal-buttons">
                        <button type="submit">Update Balance</button>
                        <button type="button" class="cancel" onclick="closeModal()">Cancel</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Account List -->
        <h2>Account List</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Account Number</th>
                    <th>User Name</th>
                    <th>Balance</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($accounts): ?>
                    <?php foreach ($accounts as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id']) ?></td>
                        <td><?= htmlspecialchars($row['account_number']) ?></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= number_format($row['balance'], 2) ?></td>
                        <td>
                            <div class="action-buttons">
                                <button type="button" class="edit" onclick="editAccount(<?= $row['id'] ?>, '<?= $row['balance'] ?>')">Edit</button>
                                <form method="post" style="display:inline;" onsubmit="return confirm('Delete this account?')">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                    <button type="submit" class="delete">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="5">No accounts found</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
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

        // Close modal when clicking outside of it
        window.onclick = function(event) {
            var modal = document.getElementById('editModal');
            if (event.target == modal) {
                closeModal();
            }
        }
    </script>
</body>
</html>
