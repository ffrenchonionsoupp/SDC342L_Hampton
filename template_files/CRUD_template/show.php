<?php
require_once __DIR__ . '/helpers.php';
$entity = get_entity();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$record = $id > 0 ? get_record($id) : null;

if (!$record) {
    http_response_code(404);
    exit('Record not found');
}

$showCols = $entity['show_columns'] ?? array_keys($entity['fields']);
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8" />
  <title><?= h(($entity['label'] ?? 'Record') . ' #' . $record[$entity['pk']]) ?></title>
  <style>
    body { font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial; max-width: 800px; margin: 24px auto; padding: 0 16px; }
    dt { font-weight: bold; }
    dd { margin: 0 0 12px 0; }
  </style>
</head>
<body>
  <h1><?= h($entity['label'] ?? 'Record') ?> #<?= h($record[$entity['pk']]) ?></h1>

  <dl>
    <?php foreach ($showCols as $c): ?>
      <dt><?= h($c) ?></dt>
      <dd><?= h((string)($record[$c] ?? '')) ?></dd>
    <?php endforeach; ?>
  </dl>

  <p>
    <a href="form.php?id=<?= urlencode($record[$entity['pk']]) ?>">Edit</a> |
    <a href="index.php">Back</a>
  </p>
</body>
</html>