<?php
require_once(__DIR__ . '/database.php');
require_once(__DIR__ . '/../controller/complaint_assignment.php');

class ComplaintAssignmentDB {

    public static function assignComplaint($assignment) {
        $db = new Database();
        $conn = $db->getDbConn();

        $query = "INSERT INTO complaint_assignments (complaint_id, technician_id)
                  VALUES (
                    '{$assignment->getComplaintId()}',
                    '{$assignment->getTechnicianId()}'
                  )";

        return $conn->query($query);
    }

    public static function getAssignmentByComplaint($complaintId) {
        $db = new Database();
        $conn = $db->getDbConn();

        $query = "SELECT a.*, u.full_name
                  FROM complaint_assignments a
                  JOIN users u ON a.technician_id = u.user_id
                  WHERE complaint_id = '$complaintId'";
        $result = $conn->query($query);

        return $result->fetch_assoc();
    }

    public static function getComplaintsByTechnician($techId) {
        $db = new Database();
        $conn = $db->getDbConn();

        $query = "SELECT c.*, u.full_name AS customer_name
                  FROM complaint_assignments a
                  JOIN complaints c ON a.complaint_id = c.complaint_id
                  JOIN users u ON c.user_id = u.user_id
                  WHERE a.technician_id = '$techId'
                  ORDER BY c.created_at DESC";
        $result = $conn->query($query);

        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }

        return $rows;
    }
}
