
<?php
// functions.php
require_once __DIR__ . '/db.php';

// READ all (list)
function fetch_all_records(): array {
    $pdo = get_pdo();
    $stmt = $pdo->query("SELECT * FROM " . TABLE_NAME . " ORDER BY " . PK . " DESC");
    return $stmt->fetchAll();
}

// READ one (by PK)
function fetch_one_record($id): ?array {
    $pdo = get_pdo();
    $stmt = $pdo->prepare("SELECT * FROM " . TABLE_NAME . " WHERE " . PK . " = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetch();
    return $row ?: null;
}

// CREATE
function create_record(array $data): int {
    // Adjust fields for your table
    $fields = ['Placeholder', 'Placeholder', 'Placeholder', 'Placeholder', 'Placeholder', 'Placeholder'];
    $placeholders = implode(',', array_fill(0, count($fields), '?'));
    $columns = implode(',', $fields);

    $pdo = get_pdo();
    $stmt = $pdo->prepare("INSERT INTO " . TABLE_NAME . " ($columns) VALUES ($placeholders)");
    $stmt->execute([
        $data['Placeholder'] ?? '',
        $data['Placeholder'] ?? '',
        $data['Placeholder'] ?? '',
        $data['Placeholder'] ?? '',
        $data['Placeholder'] ?? '',
        $data['Placeholder'] ?? '',
    ]);
    return (int)$pdo->lastInsertId();
}

// UPDATE
function update_record($id, array $data): bool {
    // Adjust fields for your table
    $fields = ['Placeholder', 'Placeholder', 'Placeholder', 'Placeholder', 'Placeholder', 'Placeholder'];
    $assignments = implode(', ', array_map(fn($f) => "$f = ?", $fields));

    $pdo = get_pdo();
    $stmt = $pdo->prepare("UPDATE " . TABLE_NAME . " SET $assignments WHERE " . PK . " = ?");
    return $stmt->execute([
        $data['Placeholder'] ?? '',
        $data['Placeholder'] ?? '',
        $data['Placeholder'] ?? '',
        $data['Placeholder'] ?? '',
        $data['Placeholder'] ?? '',
        $data['Placeholder'] ?? '',
        $id
    ]);
}

// DELETE
function delete_record($id): bool {
    $pdo = get_pdo();
    $stmt = $pdo->prepare("DELETE FROM " . TABLE_NAME . " WHERE " . PK . " = ?");
    return $stmt->execute([$id]);
}
