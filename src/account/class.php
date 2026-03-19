<?php
class Account {
    private $pdo;

    public function __construct() {
        $this->pdo = new PDO('mysql:host=db;dbname=php_test;charset=utf8', 'root', 'root123');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
    }

    public function getAll() {
        $stmt = $this->pdo->query(
            "SELECT accounts.id, users.name, accounts.balance, accounts.user_id ,accounts.account_number
             FROM accounts JOIN users ON accounts.user_id = users.id"
        );
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        $stmt = $this->pdo->query("SELECT id, name FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
