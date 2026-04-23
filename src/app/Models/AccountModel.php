<?php

class AccountModel {
    public function __construct(private PDO $db) {}

    public function all(): array {
        $stmt = $this->db->query(
            'SELECT accounts.id, users.name, users.email, accounts.balance, accounts.user_id, accounts.account_number
             FROM accounts
             JOIN users ON accounts.user_id = users.id
             ORDER BY accounts.id DESC'
        );
        return $stmt->fetchAll();
    }

    public function find(int $id): array|false {
        $stmt = $this->db->prepare(
            'SELECT accounts.id, users.name, users.email, accounts.balance, accounts.user_id, accounts.account_number
             FROM accounts
             JOIN users ON accounts.user_id = users.id
             WHERE accounts.id = :id'
        );
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function create(array $data): int {
        if (empty($data['user_id']) || empty($data['account_number']) || !isset($data['balance'])) {
            throw new InvalidArgumentException('Missing required fields: user_id, account_number, balance');
        }

        $stmt = $this->db->prepare(
            'INSERT INTO accounts (user_id, account_number, balance) VALUES (:user_id, :account_number, :balance)'
        );
        $stmt->execute([
            'user_id' => $data['user_id'],
            'account_number' => $data['account_number'],
            'balance' => $data['balance'],
        ]);

        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, array $data): bool {
        if (!isset($data['balance'])) {
            throw new InvalidArgumentException('Missing required field: balance');
        }

        $stmt = $this->db->prepare('UPDATE accounts SET balance = :balance WHERE id = :id');
        $stmt->execute([
            'balance' => $data['balance'],
            'id' => $id,
        ]);

        return $stmt->rowCount() > 0;
    }

    public function delete(int $id): bool {
        $stmt = $this->db->prepare('DELETE FROM accounts WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->rowCount() > 0;
    }

    public function users(): array {
        $stmt = $this->db->query('SELECT id, name FROM users ORDER BY name ASC');
        return $stmt->fetchAll();
    }
}
