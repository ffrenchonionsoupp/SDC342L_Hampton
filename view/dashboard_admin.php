// all complaints
// assign complaint
// manage users
<?php
session_start();
require_once(__DIR__ . '/../controller/user_controller.php');
require_once(__DIR__ . '/../controller/complaint_controller.php');

UserController::requireLogin();

$complaints = ComplaintController::getAllComplaints();
?>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<h1>Admin Dashboard</h1>
<p>Welcome, <?php echo $_SESSION['full_name']; ?></p>

<h2>All Complaints</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Status</th>
        <th>Customer</th>
        <th>Created</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
    </tr>

    <?php foreach ($complaints as $c): ?>
        <tr>
            <td><?php echo $c['complaint_id']; ?></td>
            <td><?php echo htmlspecialchars($c['title']); ?></td>
            <td><?php echo $c['status']; ?></td>
            <td><?php echo $c['full_name']; ?></td>
            <td><?php echo $c['created_at']; ?></td>
            <td>
                <a href="complaint_details.php?id=<?php echo $c['complaint_id']; ?>">View</a>
            </td>
            <td>
                <a href="assign_complaint.php?id=<?php echo $c['complaint_id']; ?>">Assign</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
