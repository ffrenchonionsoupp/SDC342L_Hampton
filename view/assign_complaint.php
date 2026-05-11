<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once(__DIR__ . '/../controller/user_controller.php');
require_once(__DIR__ . '/../controller/complaint_controller.php');
require_once(__DIR__ . '/../model/user_db.php');

UserController::requireLogin();

if (!isset($_GET['id'])) {
    die('Complaint ID missing');
}

$complaintId = $_GET['id'];

$technicians = UsersDB::getUsersByRole(2);

if (isset($_POST['assign'])) {

    ComplaintController::assignComplaint(
        $_POST['complaint_id'],
        $_POST['technician_id']
    );

    header('Location: dashboard_admin.php');
    exit();
}
?>

<html>

<head>
    <title>Assign Complaint</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>

<h1>Assign Complaint</h1>

<form method="POST">

    <input type="hidden"
           name="complaint_id"
           value="<?php echo $complaintId; ?>">

    <p>

        Technician:

        <select name="technician_id">

            <?php foreach ($technicians as $tech): ?>

                <option value="<?php echo $tech['user_id']; ?>">

                    <?php echo $tech['full_name']; ?>

                </option>

            <?php endforeach; ?>

        </select>

    </p>

    <p>

        <input type="submit"
               name="assign"
               value="Assign Complaint">

        <a href="dashboard_admin.php">Cancel</a>

    </p>

</form>

</body>

</html>