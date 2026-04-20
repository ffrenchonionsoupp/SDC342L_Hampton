<?php
require_once __DIR__ . '/helpers.php';
$entity = get_entity();
csrf_verify();

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

// Gather input according to fields
$input = [];
foreach ($entity['fields'] as $name => $meta) {
    $input[$name] = trim((string)($_POST[$name] ?? ''));
}

// Validate
$errors = validate($input);
if (!empty($errors)) {
    http_response_code(422);
    echo "<h3>Validation errors:</h3><ul>";
    foreach ($errors as $e) echo "<li>" . h($e) . "</li>";
    echo "</ul><p><a href=\"javascript:history.back()\">Back</a></p>";
    exit;
}

try {
    if ($id > 0) {
        update_record($id, $input);
    } else {
        create_record($input);
    }
    header('Location: index.php');
    exit;
} catch (Throwable $e) {
    http_response_code(500);
    echo "Error: " . h($e->getMessage());
}