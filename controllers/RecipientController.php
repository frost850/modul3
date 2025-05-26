<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Recipient.php';

class RecipientController {
    public function index() {
        $recipients = Recipient::all();
        echo json_encode($recipients);
    }

    public function store() {
        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['nik'], $data['name'], $data['category'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing fields']);
            return;
        }

        $recipient = Recipient::create($data);
        echo json_encode($recipient);
    }
}
