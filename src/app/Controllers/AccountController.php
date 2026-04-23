<?php

class AccountController extends Controller {
    private AccountModel $accounts;

    public function __construct() {
        global $db;
        $this->accounts = new AccountModel($db);
    }

    public function index(): void {
        $this->render('account/index', [
            'title' => 'Accounts',
            'activePage' => 'accounts',
            'user' => AuthService::user(),
            'isAdmin' => true,
            'accounts' => $this->accounts->all(),
            'users' => $this->accounts->users(),
            'error' => $_SESSION['flash_error'] ?? '',
        ]);

        unset($_SESSION['flash_error']);
    }

    public function store(): void {
        try {
            $this->accounts->create([
                'user_id' => $_POST['user_id'] ?? null,
                'account_number' => trim($_POST['account_number'] ?? ''),
                'balance' => $_POST['balance'] ?? 0,
            ]);
        } catch (Throwable $exception) {
            $_SESSION['flash_error'] = $exception->getMessage();
        }

        $this->redirect('/accounts');
    }

    public function update(): void {
        try {
            $this->accounts->update((int) ($_POST['id'] ?? 0), [
                'balance' => $_POST['balance'] ?? 0,
            ]);
        } catch (Throwable $exception) {
            $_SESSION['flash_error'] = $exception->getMessage();
        }

        $this->redirect('/accounts');
    }

    public function destroy(): void {
        $this->accounts->delete((int) ($_POST['id'] ?? 0));
        $this->redirect('/accounts');
    }
}
