<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Distribution.php';

class DistributionController {
    public function index() {
        $distributions = Distribution::all();
        echo json_encode($distributions);
    }

    public function store() {
        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['donation_id'], $data['schedule_date'], $data['location'], $data['admin_id'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing required fields']);
            return;
        }

        $distribution = Distribution::create($data);
        echo json_encode($distribution);
    }
}
