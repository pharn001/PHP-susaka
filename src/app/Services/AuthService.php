<?php

class AuthService {
    public function __construct(private PDO $db) {}

    public function login(string $username, string $password): bool {
        $stmt = $this->db->prepare(
            'SELECT id, name, password, role FROM users WHERE name = :username LIMIT 1'
        );
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();

        if (!$user || !password_verify($password, $user['password'])) {
            return false;
        }

        session_regenerate_id(true);
        $_SESSION['user_id'] = (int) $user['id'];
        $_SESSION['username'] = $user['name'];
        $_SESSION['role'] = $user['role'];

        return true;
    }

    public function register(string $username, string $email, string $password, string $role = 'user'): bool {
        $role = $role === 'admin' ? 'admin' : 'user';

        $check = $this->db->prepare('SELECT id FROM users WHERE name = :username OR email = :email LIMIT 1');
        $check->execute([
            'username' => $username,
            'email' => $email,
        ]);

        if ($check->fetch()) {
            throw new RuntimeException('ຊື່ຜູ້ໃຊ້ ຫຼື ອີເມວນີ້ຖືກໃຊ້ແລ້ວ');
        }

        $stmt = $this->db->prepare(
            'INSERT INTO users (name, email, password, role) VALUES (:username, :email, :password, :role)'
        );

        return $stmt->execute([
            'username' => $username,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'role' => $role,
        ]);
    }

    public function logout(): void {
        $_SESSION = [];
        session_destroy();
    }

    public function resetAdmin(string $username, string $password): void {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $findUser = $this->db->prepare('SELECT id FROM users WHERE name = :username LIMIT 1');
        $findUser->execute(['username' => $username]);
        $user = $findUser->fetch();

        if ($user) {
            $update = $this->db->prepare('UPDATE users SET password = :password, role = :role WHERE id = :id');
            $update->execute([
                'password' => $hashedPassword,
                'role' => 'admin',
                'id' => $user['id'],
            ]);
            return;
        }

        $insert = $this->db->prepare(
            'INSERT INTO users (name, email, password, role) VALUES (:username, :email, :password, :role)'
        );
        $insert->execute([
            'username' => $username,
            'email' => $username . '@local.test',
            'password' => $hashedPassword,
            'role' => 'admin',
        ]);
    }

    public static function check(): bool {
        return isset($_SESSION['user_id']);
    }

    public static function user(): array {
        return [
            'id' => $_SESSION['user_id'] ?? null,
            'username' => $_SESSION['username'] ?? 'Guest',
            'role' => $_SESSION['role'] ?? 'guest',
        ];
    }

    public static function isAdmin(): bool {
        return (($_SESSION['role'] ?? null) === 'admin');
    }
}
