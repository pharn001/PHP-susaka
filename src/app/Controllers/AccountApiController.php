<?php

class AccountApiController extends Controller {
    private AccountModel $accounts;

    public function __construct() {
        global $db;
        $this->accounts = new AccountModel($db);
    }

    public function index(): void {
        ResponseHelper::success($this->accounts->all());
    }

    public function show(string $id): void {
        $account = $this->accounts->find((int) $id);
        $account ? ResponseHelper::success($account) : ResponseHelper::notFound('Account not found');
    }

    public function store(): void {
        $id = $this->accounts->create(ResponseHelper::getJsonInput());
        ResponseHelper::success(['id' => $id], 'Account created successfully');
    }

    public function update(string $id): void {
        $updated = $this->accounts->update((int) $id, ResponseHelper::getJsonInput());
        ResponseHelper::success(['updated' => $updated], 'Account updated successfully');
    }

    public function destroy(string $id): void {
        $deleted = $this->accounts->delete((int) $id);
        $deleted ? ResponseHelper::success(['deleted' => true], 'Account deleted successfully')
            : ResponseHelper::notFound('Account not found');
    }
}
