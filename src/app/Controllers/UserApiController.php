<?php

class UserApiController extends Controller {
    private UserModel $users;

    public function __construct() {
        global $db;
        $this->users = new UserModel($db);
    }

    public function index(): void {
        ResponseHelper::success($this->users->all());
    }

    public function show(string $id): void {
        $user = $this->users->find((int) $id);
        $user ? ResponseHelper::success($user) : ResponseHelper::notFound('User not found');
    }

    public function store(): void {
        $id = $this->users->create(ResponseHelper::getJsonInput());
        ResponseHelper::success(['id' => $id], 'User created successfully');
    }

    public function update(string $id): void {
        $updated = $this->users->update((int) $id, ResponseHelper::getJsonInput());
        ResponseHelper::success(['updated' => $updated], 'User updated successfully');
    }

    public function destroy(string $id): void {
        $deleted = $this->users->delete((int) $id);
        $deleted ? ResponseHelper::success(['deleted' => true], 'User deleted successfully')
            : ResponseHelper::notFound('User not found');
    }
}
