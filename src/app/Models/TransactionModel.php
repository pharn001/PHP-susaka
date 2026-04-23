<?php

class TransactionModel {
    public function __construct(private PDO $db) {}

    public function all(): array {
        $stmt = $this->db->query(
            'SELECT transactions.id, transactions.account_id, transactions.type, transactions.amount,
                    transactions.description, transactions.reference, transactions.created_at, users.name AS user_name
             FROM transactions
             LEFT JOIN users ON transactions.user_id = users.id
             ORDER BY transactions.id DESC'
        );
        return $stmt->fetchAll();
    }

    public function find(int $id): array|false {
        $stmt = $this->db->prepare('SELECT * FROM transactions WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function create(array $data): int {
        foreach (['account_id', 'type', 'amount', 'user_id'] as $field) {
            if (!isset($data[$field]) || $data[$field] === '') {
                throw new InvalidArgumentException("ຂາດຂໍ້ມູນສຳຄັນ: {$field}");
            }
        }

        $stmt = $this->db->prepare(
            'INSERT INTO transactions (account_id, type, amount, description, reference, user_id)
             VALUES (:account_id, :type, :amount, :description, :reference, :user_id)'
        );
        $stmt->execute([
            'account_id' => $data['account_id'],
            'type' => $data['type'],
            'amount' => $data['amount'],
            'description' => $data['description'] ?? null,
            'reference' => $data['reference'] ?? null,
            'user_id' => $data['user_id'],
        ]);

        return (int) $this->db->lastInsertId();
    }

    public function delete(int $id): bool {
        $stmt = $this->db->prepare('DELETE FROM transactions WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->rowCount() > 0;
    }
}
