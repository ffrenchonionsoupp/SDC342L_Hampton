<?php
session_start();
require_once(__DIR__ . '/../controller/user_controller.php');
require_once(__DIR__ . '/../controller/complaint_controller.php');

UserController::requireLogin();

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: dashboard_customer.php');
    exit();
}

$data = ComplaintController::getComplaintDetails($id);
$complaint = $data['complaint'];
$notes = $data['notes'];
$assignment = $data['assignment'];
?>
<html>
<head>
    <title>Complaint Details</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
<h1>Complaint Details</h1>

<h2><?php echo htmlspecialchars($complaint['title']); ?></h2>
<p><strong>Status:</strong> <?php echo $complaint['status']; ?></p>
<p><strong>Customer:</strong> <?php echo $complaint['full_name']; ?></p>
<p><strong>Description:</strong><br><?php echo nl2br(htmlspecialchars($complaint['description'])); ?></p>

<?php if ($assignment): ?>
    <p><strong>Assigned To:</strong> <?php echo $assignment['full_name']; ?></p>
<?php else: ?>
    <p><strong>Assigned To:</strong> Not yet assigned</p>
<?php endif; ?>

<h3>Notes</h3>
<?php if (count($notes) == 0): ?>
    <p>No notes yet.</p>
<?php else: ?>
    <ul>
        <?php foreach ($notes as $n): ?>
            <li>
                <strong><?php echo $n['full_name']; ?></strong>
                (<?php echo $n['created_at']; ?>):<br>
                <?php echo nl2br(htmlspecialchars($n['note_text'])); ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<p><a href="dashboard_customer.php">Back</a></p>
</body>
</html>
