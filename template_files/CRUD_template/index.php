<?php
require_once __DIR__ . '/helpers.php';
$entity = get_entity();
$rows = list_records();
$listCols = $entity['list_columns'] ?? array_keys($entity['fields']);
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8" />
  <title><?= h($entity['label'] ?? 'Records') ?> — List</title>
  <style>
    body { font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial; max-width: 1000px; margin: 24px auto; padding: 0 16px; }
    table { width:100%; border-collapse: collapse; }
    th, td { padding: 8px; border-bottom: 1px solid #eee; }
    a { color: #2563eb; text-decoration: none; }
    .actions a, .actions form { display:inline-block; margin-right:6px; }
  </style>
</head>
<body>
  <h1><?= h($entity['label'] ?? 'Records') ?></h1>

  <p><a href="form.php">Create New</a></p>

  <table>
    <thead>
      <tr>
        <th><?= h($entity['pk']) ?></th>
        <?php foreach ($listCols as $c): ?>
          <th><?= h($c) ?></th>
        <?php endforeach; ?>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($rows)): ?>
        <tr><td colspan="<?= 2 + count($listCols) ?>">No records.</td></tr>
      <?php else: ?>
        <?php foreach ($rows as $r): ?>
          <tr>
            <td><?= h($r[$entity['pk']]) ?></td>
            <?php foreach ($listCols as $c): ?>
              <td><?= h((string)($r[$c] ?? '')) ?></td>
            <?php endforeach; ?>
            <td class="actions">
              <a href="show.php?id=<?= urlencode($r[$entity['pk']]) ?>">View</a>
              <a href="form.php?id=<?= urlencode($r[$entity['pk']]) ?>">Edit</a>
              <form action="delete.php" method="post" onsubmit="return confirm('Delete this record?');">
                <?= csrf_input() ?>
                <input type="hidden" name="id" value="<?= h($r[$entity['pk']]) ?>">
                <button type="submit">Delete</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
</body>
</html>