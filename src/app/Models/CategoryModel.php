<?php

class CategoryModel {
    public function __construct(private PDO $db) {}

    public function all(): array {
        $stmt = $this->db->query('SELECT id, slug, name, icon, color, status, created_at FROM categories WHERE status = 1 ORDER BY id ASC');
        return $stmt->fetchAll();
    }
}
