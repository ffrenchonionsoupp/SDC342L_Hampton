<?php
session_start();
require_once(__DIR__ . '/../controller/user_controller.php');
require_once(__DIR__ . '/../controller/complaint_controller.php');
require_once(__DIR__ . '/../model/complaint_note_db.php');

UserController::requireLogin();
$userId = UserController::getCurrentUserId();

$complaintId = $_GET['complaint_id'] ?? null;
$noteId = $_GET['note_id'] ?? null;

$editing = false;
$error = '';

if ($noteId) {
    $editing = true;
    $note = ComplaintNoteDB::getNoteById($noteId);
}

if (isset($_POST['save'])) {
    $text = trim($_POST['note_text']);

    if ($text === '') {
        $error = "Required";
    } else {
        if ($editing) {
            ComplaintNoteDB::updateNote($noteId, $text);
        } else {
            ComplaintController::addNote($complaintId, $userId, $text);
        }

        header("Location: complaint_details.php?id=$complaintId");
        exit();
    }
}
?>
<html>
<head>
    <title><?php echo $editing ? "Edit Note" : "Add Note"; ?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<h1><?php echo $editing ? "Edit Note" : "Add Note"; ?></h1>

<form method="POST">
    <p>Note:<br>
        <textarea name="note_text" rows="5" cols="50"><?php
            echo $_POST['note_text'] ?? ($editing ? $note['note_text'] : '');
        ?></textarea>
        <span class="error"><?php echo $error; ?></span>
    </p>

    <p>
        <input type="submit" name="save" value="Save">
        <a href="complaint_details.php?id=<?php echo $complaintId; ?>">Cancel</a>
    </p>
</form>

</body>
</html>
