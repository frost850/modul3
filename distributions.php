<?php
require_once 'config/database.php';
require_once 'config/jwt_validator.php';
require_once 'models/DistributionModel.php';

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PATCH");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

try {
    // Validasi JWT Admin
    $token = getallheaders()['Authorization'] ?? '';
    JWTValidator::validateAdminToken($token);

    $distributionModel = new DistributionModel($conn);
    $input = json_decode(file_get_contents('php://input'), true);

    switch ($_SERVER['REQUEST_METHOD']) {
        case 'POST':
            $donasi_id = $input['donasi_id'] ?? null;
            $recipients = $input['recipients'] ?? null;

            if (empty($donasi_id) || empty($recipients)) {
                http_response_code(400);
                echo json_encode(['error' => 'donasi_id dan recipients wajib diisi']);
                break;
            }
            $result = $distributionModel->distributeDonation($donasi_id, $recipients, $token);
            echo json_encode($result);
            break;
        case 'GET':
            $donasi_id = $_GET['donasi_id'] ?? null;
            if (!$donasi_id) {
                http_response_code(400);
                echo json_encode(['error' => 'donasi_id is required']);
                break;
            }
            $distributions = $distributionModel->getDistributionsByDonationId($donasi_id);
            echo json_encode($distributions);
            break;
        case 'PUT':
            $input = json_decode(file_get_contents('php://input'), true);
            $distribution_id = $input['distribution_id'] ?? null;
            $status = $input['status'] ?? null;

            if (!$distribution_id || !$status) {
                http_response_code(400);
                echo json_encode(['error' => 'distribution_id dan status wajib diisi']);
                break;
            }

            $updated = $distributionModel->updateDistributionStatus($distribution_id, $status);
            if ($updated) {
                echo json_encode(['message' => 'Status distribusi berhasil diubah']);
            } else {
                http_response_code(404);
                echo json_encode(['error' => 'Distribusi tidak ditemukan atau status tidak berubah']);
            }
            break;
        default:
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
    }
} catch (Exception $e) {
    http_response_code($e->getCode() ?: 500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>