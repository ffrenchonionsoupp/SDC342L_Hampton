<?php
require_once __DIR__ . '/helpers.php';
$entity = get_entity();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$editing = $id > 0;
$record = $editing ? get_record($id) : null;

if ($editing && !$record) {
    http_response_code(404);
    exit('Record not found');
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8" />
  <title><?= $editing ? 'Edit' : 'New' ?> <?= h($entity['label'] ?? 'Record') ?></title>
  <style>
    body { font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial; max-width: 800px; margin: 24px auto; padding: 0 16px; }
    label { display:block; margin:10px 0; }
    input, textarea, select { padding:8px; }
    .row { display:grid; gap:12px; grid-template-columns: 1fr 1fr; }
  </style>
</head>
<body>
  <h1><?= $editing ? 'Edit' : 'New' ?> <?= h($entity['label'] ?? 'Record') ?></h1>

  <form action="save.php" method="post" novalidate>
    <?= csrf_input() ?>
    <?php if ($editing): ?>
      <input type="hidden" name="id" value="<?= h($id) ?>">
    <?php endif; ?>

    <?php foreach ($entity['fields'] as $name => $meta): ?>
      <?= render_input($name, $meta, $record[$name] ?? '') ?>
    <?php endforeach; ?>

    <p>
      <button type="submit"><?= $editing ? 'Update' : 'Create' ?></button>
      <a href="index.php">Cancel</a>
    </p>
  </form>
</body>
</html>