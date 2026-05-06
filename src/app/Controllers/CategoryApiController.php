<?php

class CategoryApiController extends ApiController {
    private CategoryModel $categories;

    public function __construct() {
        global $db;
        $this->categories = new CategoryModel($db);
    }

    public function index(): void {
        $this->handle(function (): void {
            ResponseHelper::success($this->categories->all());
        });
    }
}
