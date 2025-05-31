<?php
require_once 'config/database.php';
require_once 'config/jwt_validator.php';
require_once 'models/RecipientModel.php';

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

try {
    // Ambil token dari header Authorization
    $headers = getallheaders();
    $token = $headers['Authorization'] ?? '';

    // Validasi JWT Admin untuk semua metode kecuali GET
    $method = $_SERVER['REQUEST_METHOD'];
    if (!in_array($method, ['GET'])) {
        if (!$token) {
            throw new Exception("Token tidak ditemukan di header Authorization", 401);
        }
        JWTValidator::validateAdminToken($token);
    }

    $recipientModel = new RecipientModel($conn);
    
    // Baca input dan validasi JSON
    $inputRaw = file_get_contents('php://input');
    $input = json_decode($inputRaw, true);
    if ($inputRaw && $input === null && json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception("Format JSON tidak valid", 400);
    }

    switch ($method) {
        case 'POST':
            if (empty($input['nama']) || empty($input['alamat'])) {
                throw new Exception("Nama dan alamat wajib diisi", 400);
            }
            $id = $recipientModel->create($input);
            echo json_encode(['id' => $id]);
            break;

        case 'GET':
            $id = $_GET['id'] ?? null;
            echo json_encode($recipientModel->get($id));
            break;

        case 'PUT':
            $id = $_GET['id'] ?? null;
            if (!$id || empty($input)) {
                throw new Exception("ID dan data update wajib diisi", 400);
            }
            $recipientModel->update($id, $input);
            echo json_encode(['message' => 'Data updated']);
            break;

        case 'DELETE':
            $id = $_GET['id'] ?? null;
            if (!$id) {
                throw new Exception("ID wajib diisi", 400);
            }
            $recipientModel->delete($id);
            echo json_encode(['message' => 'Penerima dinonaktifkan']);
            break;

        case 'PATCH':
            $id = $_GET['id'] ?? null;
            if (!$id) {
                throw new Exception("ID wajib diisi", 400);
            }
            $recipientModel->restore($id);
            echo json_encode(['message' => 'Penerima diaktifkan kembali']);
            break;

        default:
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
    }
} catch (Exception $e) {
    $code = $e->getCode();
    if ($code < 100 || $code >= 600) $code = 500; // fallback code
    http_response_code($code);
    echo json_encode([
        'error' => $e->getMessage(),
        'status' => 'failed'
    ]);
}
?>
