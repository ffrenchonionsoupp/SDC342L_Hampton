<?php
session_start();
require_once(__DIR__ . '/../controller/user_controller.php');
require_once(__DIR__ . '/../controller/complaint_controller.php');

UserController::requireLogin();
$userId = UserController::getCurrentUserId();

$editing = false;
$errorTitle = '';
$errorDesc = '';

if (isset($_GET['id'])) {
    $editing = true;
    $data = ComplaintController::getComplaintDetails($_GET['id']);
    $complaint = $data['complaint'];
}

if (isset($_POST['save'])) {
    $title = trim($_POST['title']);
    $desc = trim($_POST['description']);
    $valid = true;

    if ($title === '') {
        $errorTitle = "Required";
        $valid = false;
    }

    if ($desc === '') {
        $errorDesc = "Required";
        $valid = false;
    }

    if ($valid) {
        if ($editing) {
            ComplaintController::updateStatus($_POST['complaint_id'], $_POST['status']);
            ComplaintController::addComplaint($userId, $title, $desc);
        } else {
            ComplaintController::addComplaint($userId, $title, $desc);
        }

        header('Location: dashboard_customer.php');
        exit();
    }
}
?>
<html>
<head>
    <title><?php echo $editing ? "Update Complaint" : "Submit Complaint"; ?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<h1><?php echo $editing ? "Update Complaint" : "Submit New Complaint"; ?></h1>

<form method="POST">

    <p>Title:
        <input type="text" name="title"
               value="<?php echo $_POST['title'] ?? ($editing ? $complaint['title'] : ''); ?>">
        <span class="error"><?php echo $errorTitle; ?></span>
    </p>

    <p>Description:<br>
        <textarea name="description" rows="5" cols="50"><?php
            echo $_POST['description'] ?? ($editing ? $complaint['description'] : '');
        ?></textarea>
        <span class="error"><?php echo $errorDesc; ?></span>
    </p>

    <?php if ($editing): ?>
        <p>Status:
            <select name="status">
                <?php
                $statuses = ['open','assigned','in_progress','resolved','closed'];
                foreach ($statuses as $s) {
                    $sel = ($complaint['status'] == $s) ? "selected" : "";
                    echo "<option value='$s' $sel>$s</option>";
                }
                ?>
            </select>
        </p>
        <input type="hidden" name="complaint_id" value="<?php echo $complaint['complaint_id']; ?>">
    <?php endif; ?>

    <p>
        <input type="submit" name="save" value="Save">
        <a href="dashboard_customer.php">Cancel</a>
    </p>

</form>

</body>
</html>
