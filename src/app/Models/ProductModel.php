<?php

class ProductModel {
    public function __construct(private PDO $db) {}

    public function all(): array {
        $stmt = $this->db->query('
            SELECT p.id, p.name, p.price, p.img, c.slug as cat 
            FROM products p 
            LEFT JOIN categories c ON p.category_id = c.id 
            WHERE p.status = 1 
            ORDER BY p.id ASC
        ');
        return $stmt->fetchAll();
    }
}
