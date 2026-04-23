<?php

class AccountApiController extends ApiController {
    private AccountModel $accounts;

    public function __construct() {
        global $db;
        $this->accounts = new AccountModel($db);
    }

    public function index(): void {
        $this->handle(function (): void {
            ResponseHelper::success($this->accounts->all());
        });
    }

    public function show(string $id): void {
        $this->handle(function () use ($id): void {
            $account = $this->accounts->find((int) $id);
            $account ? ResponseHelper::success($account) : ResponseHelper::notFound('ບໍ່ພົບຂໍ້ມູນບັນຊີ');
        });
    }

    public function store(): void {
        $this->handle(function (): void {
            $id = $this->accounts->create(ResponseHelper::getJsonInput());
            ResponseHelper::success(['id' => $id], 'ສ້າງບັນຊີສຳເລັດແລ້ວ');
        });
    }

    public function update(string $id): void {
        $this->handle(function () use ($id): void {
            $updated = $this->accounts->update((int) $id, ResponseHelper::getJsonInput());
            ResponseHelper::success(['updated' => $updated], 'ອັບເດດບັນຊີສຳເລັດແລ້ວ');
        });
    }

    public function destroy(string $id): void {
        $this->handle(function () use ($id): void {
            $deleted = $this->accounts->delete((int) $id);
            $deleted ? ResponseHelper::success(['deleted' => true], 'ລຶບບັນຊີສຳເລັດແລ້ວ')
                : ResponseHelper::notFound('ບໍ່ພົບຂໍ້ມູນບັນຊີ');
        });
    }
}
