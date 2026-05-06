<?php

class OrderApiController extends ApiController {
    private OrderModel $orders;

    public function __construct() {
        global $db;
        $this->orders = new OrderModel($db);
    }

    public function store(): void {
        $this->handle(function (): void {
            $input = json_decode(file_get_contents('php://input'), true);
            if (!$input) {
                ResponseHelper::error('Invalid input');
                return;
            }

            $orderData = [
                'status' => $input['status'] ?? 'completed',
                'subtotal' => $input['totals']['subtotal'] ?? 0,
                'discount_type' => $input['discount']['type'] ?? null,
                'discount_value' => $input['discount']['value'] ?? 0,
                'discount_amount' => $input['totals']['discAmt'] ?? 0,
                'tax_rate' => ($input['taxRate'] ?? 0) * 100, // convert 0.08 to 8%
                'tax_amount' => $input['totals']['tax'] ?? 0,
                'total' => $input['totals']['total'] ?? 0,
                'payment_method' => $input['payment']['method'] ?? null,
                'cash_received' => $input['payment']['amount'] ?? 0,
                'cash_change' => $input['payment']['change'] ?? 0,
                'items' => []
            ];

            if (!empty($input['items'])) {
                foreach ($input['items'] as $item) {
                    $isCustom = strpos((string)$item['product']['id'], 'custom_') === 0;
                    $orderData['items'][] = [
                        'product_id' => $isCustom ? null : $item['product']['id'],
                        'product_name' => $item['product']['name'],
                        'price' => $item['product']['price'],
                        'quantity' => $item['quantity'],
                        'line_total' => $item['lineTotal'],
                        'note' => $item['note'] ?? null,
                        'is_custom' => $isCustom ? 1 : 0
                    ];
                }
            }

            $result = $this->orders->create($orderData);
            if ($result['success']) {
                ResponseHelper::success(['order_number' => $result['order_number']]);
            } else {
                ResponseHelper::error($result['error']);
            }
        });
    }
}
