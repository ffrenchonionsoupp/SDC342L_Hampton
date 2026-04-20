<?php
// helpers.php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/config.php';

session_start(); // for CSRF tokens

function h(?string $s): string { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

function csrf_token(): string {
    if (empty($_SESSION['_csrf'])) {
        $_SESSION['_csrf'] = bin2hex(random_bytes(16));
    }
    return $_SESSION['_csrf'];
}
function csrf_input(): string {
    return '<input type="hidden" name="_csrf" value="' . h(csrf_token()) . '">';
}
function csrf_verify(): void {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $t = $_POST['_csrf'] ?? '';
        if (!$t || !hash_equals($_SESSION['_csrf'] ?? '', $t)) {
            http_response_code(403);
            exit('Invalid CSRF token');
        }
    }
}

function get_entity(): array {
    global $ENTITY;
    return $ENTITY;
}

// ---------- CRUD (Generic) ----------
function list_records(): array {
    $entity = get_entity();
    $pdo = get_pdo();
    $order = $entity['order_by'] ?? ($entity['pk'] . ' DESC');
    $stmt = $pdo->query("SELECT * FROM {$entity['table']} ORDER BY $order");
    return $stmt->fetchAll();
}

function get_record($id): ?array {
    $entity = get_entity();
    $pdo = get_pdo();
    $stmt = $pdo->prepare("SELECT * FROM {$entity['table']} WHERE {$entity['pk']} = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetch();
    return $row ?: null;
}

function create_record(array $data): int {
    $entity = get_entity();
    $cols = array_keys($entity['fields']);               // exclude PK
    $placeholders = implode(',', array_fill(0, count($cols), '?'));
    $columns = implode(',', $cols);
    $values = [];
    foreach ($cols as $c) $values[] = $data[$c] ?? null;

    $pdo = get_pdo();
    $stmt = $pdo->prepare("INSERT INTO {$entity['table']} ($columns) VALUES ($placeholders)");
    $stmt->execute($values);
    return (int)$pdo->lastInsertId();
}

function update_record($id, array $data): bool {
    $entity = get_entity();
    $cols = array_keys($entity['fields']);
    $assign = implode(', ', array_map(fn($c) => "$c = ?", $cols));
    $values = [];
    foreach ($cols as $c) $values[] = $data[$c] ?? null;
    $values[] = $id;

    $pdo = get_pdo();
    $stmt = $pdo->prepare("UPDATE {$entity['table']} SET $assign WHERE {$entity['pk']} = ?");
    return $stmt->execute($values);
}

function delete_record($id): bool {
    $entity = get_entity();
    $pdo = get_pdo();
    $stmt = $pdo->prepare("DELETE FROM {$entity['table']} WHERE {$entity['pk']} = ?");
    return $stmt->execute([$id]);
}

// ---------- Validation ----------
function validate(array $input): array {
    $entity = get_entity();
    $errors = [];
    foreach ($entity['fields'] as $name => $meta) {
        $val = trim((string)($input[$name] ?? ''));
        if (!empty($meta['required']) && $val === '') {
            $errors[] = ($meta['label'] ?? $name) . ' is required';
        }
        if (($meta['type'] ?? '') === 'number' && $val !== '' && !is_numeric($val)) {
            $errors[] = ($meta['label'] ?? $name) . ' must be a number';
        }
        if (($meta['type'] ?? '') === 'email' && $val !== '' && !filter_var($val, FILTER_VALIDATE_EMAIL)) {
            $errors[] = ($meta['label'] ?? $name) . ' must be a valid email';
        }
        if (($meta['type'] ?? '') === 'url' && $val !== '' && !filter_var($val, FILTER_VALIDATE_URL)) {
            $errors[] = ($meta['label'] ?? $name) . ' must be a valid URL';
        }
        // add more rules as needed
    }
    return $errors;
}

// ---------- Form Rendering ----------
function render_input(string $name, array $meta, $value = ''): string {
    $label = $meta['label'] ?? $name;
    $type  = $meta['type']  ?? 'text';
    $req   = !empty($meta['required']) ? 'required' : '';
    $v     = h((string)$value);

    if ($type === 'textarea') {
        return "<label>$label<br><textarea name=\"$name\" $req rows=\"4\" style=\"width:100%\">$v</textarea></label>";
    }
    if ($type === 'select') {
        $opts = $meta['options'] ?? [];
        $html = "<label>$label<br><select name=\"$name\" $req style=\"width:100%\">";
        $html .= "<option value=\"\">-- Select --</option>";
        foreach ($opts as $key => $text) {
            $sel = ($key == $value) ? 'selected' : '';
            $html .= "<option value=\"" . h($key) . "\" $sel>" . h($text) . "</option>";
        }
        $html .= "</select></label>";
        return $html;
    }
    // default input
    $inputType = in_array($type, ['text','number','email','url','date']) ? $type : 'text';
    return "<label>$label<br><input type=\"$inputType\" name=\"$name\" value=\"$v\" $req style=\"width:100%\" /></label>";
}
