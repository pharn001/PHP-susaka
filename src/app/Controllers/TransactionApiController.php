<?php

class TransactionApiController extends Controller {
    private TransactionModel $transactions;

    public function __construct() {
        global $db;
        $this->transactions = new TransactionModel($db);
    }

    public function index(): void {
        ResponseHelper::success($this->transactions->all());
    }

    public function show(string $id): void {
        $transaction = $this->transactions->find((int) $id);
        $transaction ? ResponseHelper::success($transaction) : ResponseHelper::notFound('Transaction not found');
    }

    public function store(): void {
        $id = $this->transactions->create(ResponseHelper::getJsonInput());
        ResponseHelper::success(['id' => $id], 'Transaction created successfully');
    }

    public function destroy(string $id): void {
        $deleted = $this->transactions->delete((int) $id);
        $deleted ? ResponseHelper::success(['deleted' => true], 'Transaction deleted successfully')
            : ResponseHelper::notFound('Transaction not found');
    }
}
