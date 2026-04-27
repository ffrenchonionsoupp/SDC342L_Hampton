// assigned complaints
// add note
// update status
<?php
session_start();
require_once(__DIR__ . '/../controller/user_controller.php');
require_once(__DIR__ . '/../controller/complaint_controller.php');

UserController::requireLogin();

$techId = UserController::getCurrentUserId();
$complaints = ComplaintController::getComplaintsForTechnician($techId);
?>
<html>
<head>
    <title>Technician Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<h1>Technician Dashboard</h1>
<p>Welcome, <?php echo $_SESSION['full_name']; ?></p>

<h2>Assigned Complaints</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Status</th>
        <th>Customer</th>
        <th>Created</th>
        <th>&nbsp;</th>
    </tr>

    <?php foreach ($complaints as $c): ?>
        <tr>
            <td><?php echo $c['complaint_id']; ?></td>
            <td><?php echo htmlspecialchars($c['title']); ?></td>
            <td><?php echo $c['status']; ?></td>
            <td><?php echo $c['customer_name']; ?></td>
            <td><?php echo $c['created_at']; ?></td>
            <td>
                <a href="complaint_details.php?id=<?php echo $c['complaint_id']; ?>">View</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
