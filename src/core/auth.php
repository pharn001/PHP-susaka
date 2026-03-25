<?php

class Auth {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

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
        $role = 'user';

        $check = $this->db->prepare('SELECT id FROM users WHERE name = :username OR email = :email LIMIT 1');
        $check->execute([
            'username' => $username,
            'email' => $email,
        ]);

        if ($check->fetch()) {
            throw new RuntimeException('Username ຫຼື Email ນີ້ໄດ້ຖືກນຳໃຊ້ແລ້ວ');
        }

        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare(
            'INSERT INTO users (name, email, password, role) VALUES (:username, :email, :password, :role)'
        );

        return $stmt->execute([
            'username' => $username,
            'email' => $email,
            'password' => $hashed,
            'role' => $role,
        ]);
    }
}

function isLoggedIn(): bool {
    return isset($_SESSION['user_id']);
}

function requireLogin(string $redirect = '/login/index.php'): void {
    if (!isLoggedIn()) {
        header('Location: ' . $redirect);
        exit;
    }
}

function requireRole(string $role, string $redirect = '/index.php'): void {
    requireLogin();

    if (($_SESSION['role'] ?? null) !== $role) {
        header('Location: ' . $redirect);
        exit;
    }
}
