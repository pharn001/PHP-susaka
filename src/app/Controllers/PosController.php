<?php 

class PosController extends Controller {
    public function index():void{
        $this->render('pos/index',[
              'title' => 'pos nothing ',
            'layoutMode' => 'guest',
            'error' => $_SESSION['flash_error'] ?? '',
            'success' => $_SESSION['flash_success'] ?? '',
            'credentials' => $_SESSION['flash_credentials'] ?? [],
        ]);
    }
}