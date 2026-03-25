<?php
require_once __DIR__ . '/../db.php';

class Account {
    private PDO $pdo;

    public function __construct() {
        global $db;
        $this->pdo = $db;
    }

    public function getAll() {
        try {
            $stmt = $this->pdo->query(
                "SELECT accounts.id, users.name, accounts.balance, accounts.user_id ,accounts.account_number
                 FROM accounts JOIN users ON accounts.user_id = users.id"
            );
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            return [];
        }
    }

    public function create($user_id, $account_number, $balance) {
        $stmt = $this->pdo->prepare("INSERT INTO accounts (user_id, account_number, balance) VALUES (?, ?, ?)");
        return $stmt->execute([$user_id, $account_number, $balance]);
    }

    public function update($id, $balance) {
        $stmt = $this->pdo->prepare("UPDATE accounts SET balance = ? WHERE id = ?");
        return $stmt->execute([$balance, $id]);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM accounts WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function getUsers() {
        try {
            $stmt = $this->pdo->query("SELECT id, name FROM users");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            return [];
        }
    }
}
