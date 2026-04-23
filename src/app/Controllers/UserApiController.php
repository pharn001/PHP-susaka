<?php

class UserApiController extends ApiController {
    private UserModel $users;

    public function __construct() {
        global $db;
        $this->users = new UserModel($db);
    }

    public function index(): void {
        $this->handle(function (): void {
            ResponseHelper::success($this->users->all());
        });
    }

    public function show(string $id): void {
        $this->handle(function () use ($id): void {
            $user = $this->users->find((int) $id);
            $user ? ResponseHelper::success($user) : ResponseHelper::notFound('ບໍ່ພົບຂໍ້ມູນຜູ້ໃຊ້');
        });
    }

    public function store(): void {
        $this->handle(function (): void {
            $id = $this->users->create(ResponseHelper::getJsonInput());
            ResponseHelper::success(['id' => $id], 'ສ້າງຜູ້ໃຊ້ສຳເລັດແລ້ວ');
        });
    }

    public function update(string $id): void {
        $this->handle(function () use ($id): void {
            $updated = $this->users->update((int) $id, ResponseHelper::getJsonInput());
            ResponseHelper::success(['updated' => $updated], 'ອັບເດດຜູ້ໃຊ້ສຳເລັດແລ້ວ');
        });
    }

    public function destroy(string $id): void {
        $this->handle(function () use ($id): void {
            $deleted = $this->users->delete((int) $id);
            $deleted ? ResponseHelper::success(['deleted' => true], 'ລຶບຜູ້ໃຊ້ສຳເລັດແລ້ວ')
                : ResponseHelper::notFound('ບໍ່ພົບຂໍ້ມູນຜູ້ໃຊ້');
        });
    }
}
