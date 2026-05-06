<?php

class ProductApiController extends ApiController {
    private ProductModel $products;

    public function __construct() {
        global $db;
        $this->products = new ProductModel($db);
    }

    public function index(): void {
        $this->handle(function (): void {
            ResponseHelper::success($this->products->all());
        });
    }
}
