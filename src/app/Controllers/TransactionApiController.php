<?php

class TransactionApiController extends ApiController {
    private TransactionModel $transactions;

    public function __construct() {
        global $db;
        $this->transactions = new TransactionModel($db);
    }

    public function index(): void {
        $this->handle(function (): void {
            ResponseHelper::success($this->transactions->all());
        });
    }

    public function show(string $id): void {
        $this->handle(function () use ($id): void {
            $transaction = $this->transactions->find((int) $id);
            $transaction ? ResponseHelper::success($transaction) : ResponseHelper::notFound('ບໍ່ພົບຂໍ້ມູນທຸລະກຳ');
        });
    }

    public function store(): void {
        $this->handle(function (): void {
            $id = $this->transactions->create(ResponseHelper::getJsonInput());
            ResponseHelper::success(['id' => $id], 'ສ້າງທຸລະກຳສຳເລັດແລ້ວ');
        });
    }

    public function destroy(string $id): void {
        $this->handle(function () use ($id): void {
            $deleted = $this->transactions->delete((int) $id);
            $deleted ? ResponseHelper::success(['deleted' => true], 'ລຶບທຸລະກຳສຳເລັດແລ້ວ')
                : ResponseHelper::notFound('ບໍ່ພົບຂໍ້ມູນທຸລະກຳ');
        });
    }
}
