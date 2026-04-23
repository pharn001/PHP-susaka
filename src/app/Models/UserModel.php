<?php

class UserModel {
    public function __construct(private PDO $db) {}

    public function all(): array {
        $stmt = $this->db->query('SELECT id, name, email, role, created_at FROM users ORDER BY id DESC');
        return $stmt->fetchAll();
    }

    public function find(int $id): array|false {
        $stmt = $this->db->prepare('SELECT id, name, email, role, created_at FROM users WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function create(array $data): int {
        if (empty($data['name']) || empty($data['email']) || empty($data['password'])) {
            throw new InvalidArgumentException('ຂໍ້ມູນບໍ່ຄົບ: ຈຳເປັນຕ້ອງມີ name, email, password');
        }

        if ($this->emailExists($data['email'])) {
            throw new InvalidArgumentException('ອີເມວນີ້ຖືກໃຊ້ແລ້ວ');
        }

        $stmt = $this->db->prepare(
            'INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, :role)'
        );
        $stmt->execute([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'role' => $data['role'] ?? 'user',
        ]);

        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, array $data): bool {
        $fields = [];
        $params = ['id' => $id];

        if (isset($data['name'])) {
            $fields[] = 'name = :name';
            $params['name'] = $data['name'];
        }

        if (isset($data['email'])) {
            if ($this->emailExists($data['email'], $id)) {
                throw new InvalidArgumentException('ອີເມວນີ້ຖືກໃຊ້ແລ້ວ');
            }
            $fields[] = 'email = :email';
            $params['email'] = $data['email'];
        }

        if (isset($data['role'])) {
            $fields[] = 'role = :role';
            $params['role'] = $data['role'];
        }

        if (isset($data['password']) && $data['password'] !== '') {
            $fields[] = 'password = :password';
            $params['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        if ($fields === []) {
            throw new InvalidArgumentException('ບໍ່ມີຂໍ້ມູນໃຫ້ອັບເດດ');
        }

        $stmt = $this->db->prepare('UPDATE users SET ' . implode(', ', $fields) . ' WHERE id = :id');
        $stmt->execute($params);

        return $stmt->rowCount() > 0;
    }

    public function delete(int $id): bool {
        $stmt = $this->db->prepare('DELETE FROM users WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->rowCount() > 0;
    }

    private function emailExists(string $email, ?int $excludeId = null): bool {
        $sql = 'SELECT COUNT(*) FROM users WHERE email = :email';
        $params = ['email' => $email];

        if ($excludeId !== null) {
            $sql .= ' AND id != :exclude_id';
            $params['exclude_id'] = $excludeId;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return (bool) $stmt->fetchColumn();
    }
}
