<?php
require_once __DIR__ . '/helpers.php';
$entity = get_entity();
csrf_verify();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method not allowed');
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
if ($id <= 0) {
    http_response_code(400);
    exit('Invalid id');
}

try {
    delete_record($id);
    header('Location: index.php');
    exit;
} catch (Throwable $e) {
    http_response_code(500);
    echo "Error: " . h($e->getMessage());
}