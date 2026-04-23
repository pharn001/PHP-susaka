<?php
// ຕົວຊ່ວຍສົ່ງຄຳຕອບ JSON ກັບໄປຫາ client
class ResponseHelper {
    public static function send($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
    
    public static function success($data = null, $message = 'ສຳເລັດ') {
        self::send([
            'success' => true,
            'message' => $message,
            'data' => $data
        ]);
    }
    
    public static function error($message, $statusCode = 400) {
        self::send([
            'success' => false,
            'error' => $message
        ], $statusCode);
    }
    
    public static function notFound($message = 'ບໍ່ພົບຂໍ້ມູນ') {
        self::error($message, 404);
    }
    
    public static function methodNotAllowed() {
        self::error('ບໍ່ອະນຸຍາດໃຫ້ໃຊ້ method ນີ້', 405);
    }
    
    public static function getJsonInput() {
        $input = json_decode(file_get_contents('php://input'), true);
        return is_array($input) ? $input : [];
    }
}
