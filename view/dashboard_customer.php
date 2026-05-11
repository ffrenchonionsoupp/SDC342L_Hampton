<?php
// submit complaint
// my complaints
// view status
// view notes

session_start();
require_once(__DIR__ . '/../controller/user_controller.php');
require_once(__DIR__ . '/../controller/complaint_controller.php');
require_once(__DIR__.'/../util/security.php');

UserController::requireLogin();

//confirm user is authorized for the page
Security::checkAuthority('customer');

$userId = UserController::getCurrentUserId();
$complaints = ComplaintController::getComplaintsForCustomer($userId);
?>
<html>
<head>
    <title>Customer Dashboard</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
<h1>Customer Dashboard</h1>
<p>Welcome, <?php echo $_SESSION['full_name']; ?></p>

<p><a href="add_update_complaint.php">Submit New Complaint</a></p>

<h2>My Complaints</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Status</th>
        <th>Created</th>
        <th>&nbsp;</th>
    </tr>
    <?php foreach ($complaints as $c): ?>
        <tr>
            <td><?php echo $c['complaint_id']; ?></td>
            <td><?php echo htmlspecialchars($c['title']); ?></td>
            <td><?php echo $c['status']; ?></td>
            <td><?php echo $c['created_at']; ?></td>
            <td><a href="complaint_details.php?id=<?php echo $c['complaint_id']; ?>">View</a></td>
            <td><a href="add_update_complaint.php?id=<?php echo $c['complaint_id']; ?>">Update</a></td>
        </tr>
    <?php endforeach; ?>
</table>
<p><a href="../util/logout.php">Logout</a></p>
</body>
</html>
