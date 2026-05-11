<?php

session_start();

require_once(__DIR__ . '/../controller/user_controller.php');
require_once(__DIR__ . '/../controller/complaint_controller.php');

UserController::requireLogin();

if (!isset($_GET['id'])) {
    die('Complaint ID missing');
}

$data = ComplaintController::getComplaintDetails($_GET['id']);

$complaint = $data['complaint'];
$notes = $data['notes'];

if (isset($_POST['save_note'])) {

    $status = $_POST['status'];

    $noteText =
        "Status changed to: " . $status .
        "\n\n" .
        $_POST['note_text'];

    ComplaintController::addNote(
        $complaint['complaint_id'],
        $_SESSION['user_id'],
        $noteText
    );

    ComplaintController::updateStatus(
        $complaint['complaint_id'],
        $_POST['status']
    );

    header('Location: technician_complaint_details.php?id=' . $complaint['complaint_id']);
    exit();
}
?>

<html>

<head>
    <title>Complaint Details</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>

<h1><?php echo $complaint['title']; ?></h1>

<p>
    <strong>Customer:</strong>
    <?php echo $complaint['full_name']; ?>
</p>

<p>
    <strong>Description:</strong><br>
    <?php echo nl2br($complaint['description']); ?>
</p>

<p>
    <strong>Status:</strong>
    <?php echo $complaint['status']; ?>
</p>

<?php if (!empty($complaint['uploaded_file'])): ?>

    <p>

        <a href="/finalweekproject/uploads/<?php echo $complaint['uploaded_file']; ?>"
           target="_blank">

            View Uploaded File

        </a>

    </p>

<?php endif; ?>

<hr>

<h2>Update Status / Add Note</h2>

<form method="POST">

    <p>

        Status:

        <select name="status">

            <?php
            $statuses = ['assigned','in_progress','resolved','closed'];

            foreach ($statuses as $s):

                $selected = ($complaint['status'] == $s)
                    ? 'selected'
                    : '';
            ?>

                <option value="<?php echo $s; ?>"
                        <?php echo $selected; ?>>

                    <?php echo $s; ?>

                </option>

            <?php endforeach; ?>

        </select>

    </p>

    <p>

        Note:<br>

        <textarea name="note_text"
                  rows="5"
                  cols="60"
                  required></textarea>

    </p>

    <p>

        <input type="submit"
            name="save_note"
            value="Save Update">

        <a href="dashboard_technician.php">
            Cancel
        </a>

    </p>

</form>

<hr>

<h2>Notes</h2>

<?php if (count($notes) > 0): ?>

    <?php foreach ($notes as $note): ?>

        <div style="margin-bottom:20px; border:1px solid #ccc; padding:10px;">

            <p>

                <strong>Technician:</strong>
                <?php echo $note['full_name']; ?>

            </p>

            <p>

                <?php echo nl2br($note['note_text']); ?>

            </p>

            <p>

                <small>
                    <?php echo $note['created_at']; ?>
                </small>

            </p>

        </div>

    <?php endforeach; ?>

<?php else: ?>

    <p>No notes yet.</p>

<?php endif; ?>

</body>

</html>