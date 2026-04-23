<?php

class AuthController extends Controller {
    private AuthService $authService;

    public function __construct() {
        global $db;
        $this->authService = new AuthService($db);
    }

    public function showLogin(): void {
        if (AuthService::check()) {
            $this->redirect('/');
        }

        $this->render('auth/login', [
            'title' => 'Login',
            'layoutMode' => 'guest',
            'error' => $_SESSION['flash_error'] ?? '',
            'old' => $_SESSION['flash_old'] ?? [],
        ]);

        unset($_SESSION['flash_error'], $_SESSION['flash_old']);
    }

    public function login(): void {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($username === '' || $password === '') {
            $_SESSION['flash_error'] = 'ກະລຸນາປ້ອນຊື່ຜູ້ໃຊ້ ແລະ ລະຫັດຜ່ານ';
            $_SESSION['flash_old'] = ['username' => $username];
            $this->redirect('/login');
        }

        if (!$this->authService->login($username, $password)) {
            $_SESSION['flash_error'] = 'ຊື່ຜູ້ໃຊ້ ຫຼື ລະຫັດຜ່ານບໍ່ຖືກຕ້ອງ';
            $_SESSION['flash_old'] = ['username' => $username];
            $this->redirect('/login');
        }

        $this->redirect('/');
    }

    public function showRegister(): void {
        $this->render('auth/register', [
            'title' => 'Register User',
            'activePage' => 'register',
            'user' => AuthService::user(),
            'isAdmin' => true,
            'error' => $_SESSION['flash_error'] ?? '',
            'success' => $_SESSION['flash_success'] ?? '',
            'old' => $_SESSION['flash_old'] ?? [],
        ]);

        unset($_SESSION['flash_error'], $_SESSION['flash_success'], $_SESSION['flash_old']);
    }

    public function register(): void {
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $_SESSION['flash_old'] = [
            'username' => $username,
            'email' => $email,
        ];

        if ($username === '' || $email === '' || $password === '') {
            $_SESSION['flash_error'] = 'ກະລຸນາປ້ອນຊື່ຜູ້ໃຊ້, ອີເມວ ແລະ ລະຫັດຜ່ານ';
            $this->redirect('/register');
        }

        try {
            $this->authService->register($username, $email, $password, 'user');
            $_SESSION['flash_success'] = 'ສ້າງຜູ້ໃຊ້ສຳເລັດແລ້ວ';
            unset($_SESSION['flash_old']);
        } catch (RuntimeException $exception) {
            $_SESSION['flash_error'] = $exception->getMessage();
        }

        $this->redirect('/register');
    }

    public function logout(): void {
        $this->authService->logout();
        $this->redirect('/login');
    }

    public function showResetAdmin(): void {
        $this->render('auth/reset_admin', [
            'title' => 'Reset Admin Password',
            'layoutMode' => 'guest',
            'error' => $_SESSION['flash_error'] ?? '',
            'success' => $_SESSION['flash_success'] ?? '',
            'credentials' => $_SESSION['flash_credentials'] ?? [],
        ]);

        unset($_SESSION['flash_error'], $_SESSION['flash_success'], $_SESSION['flash_credentials']);
    }

    public function resetAdmin(): void {
        $username = trim($_POST['username'] ?? 'admin');
        $password = trim($_POST['password'] ?? 'Admin@12345');

        if ($username === '' || $password === '') {
            $_SESSION['flash_error'] = 'ກະລຸນາປ້ອນຊື່ admin ແລະ ລະຫັດຜ່ານໃໝ່';
            $this->redirect('/reset-admin');
        }

        $this->authService->resetAdmin($username, $password);
        $_SESSION['flash_success'] = "ປ່ຽນລະຫັດຜ່ານຂອງ {$username} ສຳເລັດແລ້ວ";
        $_SESSION['flash_credentials'] = [
            'username' => $username,
            'password' => $password,
        ];

        $this->redirect('/reset-admin');
    }
}
