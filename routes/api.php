<?php
$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

require_once __DIR__ . '/../controllers/RecipientController.php';

// Routing manual
if ($requestUri === '/api/recipients' && $requestMethod === 'GET') {
    (new RecipientController)->index();
} elseif ($requestUri === '/api/recipients' && $requestMethod === 'POST') {
    (new RecipientController)->store();
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Route not found']);
}

require_once __DIR__ . '/../controllers/DistributionController.php';

// Recipient routes...
if ($requestUri === '/api/recipients' && $requestMethod === 'GET') {
    (new RecipientController)->index();
} elseif ($requestUri === '/api/recipients' && $requestMethod === 'POST') {
    (new RecipientController)->store();

// Distribution routes...
} elseif ($requestUri === '/api/distributions' && $requestMethod === 'GET') {
    (new DistributionController)->index();
} elseif ($requestUri === '/api/distributions' && $requestMethod === 'POST') {
    (new DistributionController)->store();
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Route not found']);
}

