<?php

class OrderModel {
    public function __construct(private PDO $db) {}

    public function create(array $data): array {
        try {
            $this->db->beginTransaction();

            // Generate order number
            $orderNumber = 'INV-' . date('Ymd') . '-' . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
            
            $stmt = $this->db->prepare('
                INSERT INTO orders (
                    order_number, status, subtotal, discount_type, discount_value, 
                    discount_amount, tax_rate, tax_amount, total, payment_method, 
                    cash_received, cash_change, cashier_id
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ');

            // Find an admin/cashier id to use as fallback
            $cashierId = null;
            $userStmt = $this->db->query("SELECT id FROM users LIMIT 1");
            $user = $userStmt->fetch();
            if ($user) {
                $cashierId = $user['id'];
            }

            $stmt->execute([
                $orderNumber,
                $data['status'] ?? 'completed',
                $data['subtotal'] ?? 0,
                $data['discount_type'] ?? null,
                $data['discount_value'] ?? 0,
                $data['discount_amount'] ?? 0,
                $data['tax_rate'] ?? 0,
                $data['tax_amount'] ?? 0,
                $data['total'] ?? 0,
                $data['payment_method'] ?? null,
                $data['cash_received'] ?? 0,
                $data['cash_change'] ?? 0,
                $cashierId
            ]);

            $orderId = $this->db->lastInsertId();

            $stmtItem = $this->db->prepare('
                INSERT INTO order_items (
                    order_id, product_id, product_name, price, quantity, line_total, note, is_custom
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ');

            if (!empty($data['items']) && is_array($data['items'])) {
                foreach ($data['items'] as $item) {
                    $stmtItem->execute([
                        $orderId,
                        $item['product_id'],
                        $item['product_name'],
                        $item['price'],
                        $item['quantity'],
                        $item['line_total'],
                        $item['note'] ?? null,
                        $item['is_custom'] ?? 0
                    ]);
                }
            }

            $this->db->commit();
            return ['success' => true, 'order_id' => $orderId, 'order_number' => $orderNumber];
        } catch (Exception $e) {
            $this->db->rollBack();
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}
