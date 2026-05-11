<?php
require_once(__DIR__ . '/database.php');
require_once(__DIR__ . '/../controller/complaint.php');

class ComplaintDB {

    public static function addComplaint($complaint) {
        $db = new Database();
        $conn = $db->getDbConn();

        $uploadedFile = $conn->real_escape_string(
            $complaint->getUploadedFile()
        );
        
        $query = "INSERT INTO complaints
                  (user_id, title, description, status, uploaded_file)
                  VALUES (
                    '{$complaint->getUserId()}',
                    '{$conn->real_escape_string($complaint->getTitle())}',
                    '{$conn->real_escape_string($complaint->getDescription())}',
                    'open',
                    '$uploadedFile'
                  )";

        return $conn->query($query);
    }

    public static function getComplaintsByUser($userId) {
        $db = new Database();
        $conn = $db->getDbConn();

        $query = "SELECT * FROM complaints WHERE user_id = '$userId' ORDER BY created_at DESC";
        $result = $conn->query($query);

        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }

        return $rows;
    }

    public static function getAllComplaints() {
        $db = new Database();
        $conn = $db->getDbConn();

        $query = "SELECT c.*, u.full_name 
                  FROM complaints c
                  JOIN users u ON c.user_id = u.user_id
                  ORDER BY c.created_at DESC";
        $result = $conn->query($query);

        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }

        return $rows;
    }

    public static function getComplaintById($id) {
        $db = new Database();
        $conn = $db->getDbConn();

        $query = "SELECT c.*, u.full_name 
                  FROM complaints c
                  JOIN users u ON c.user_id = u.user_id
                  WHERE c.complaint_id = '$id'";
        $result = $conn->query($query);

        return $result->fetch_assoc();
    }

    public static function updateStatus($id, $status) {
        $db = new Database();
        $conn = $db->getDbConn();

        $status = $conn->real_escape_string($status);
        $query = "UPDATE complaints SET status = '$status' WHERE complaint_id = '$id'";
        return $conn->query($query);
    }
    
    public static function updateComplaint(
        $complaintId,
        $title,
        $description,
        $status
    ) {
    
        $db = new Database();
        $conn = $db->getDbConn();
    
        $title = $conn->real_escape_string($title);
        $description = $conn->real_escape_string($description);
        $status = $conn->real_escape_string($status);
    
        $query = "
            UPDATE complaints
            SET
                title = '$title',
                description = '$description',
                status = '$status'
            WHERE complaint_id = '$complaintId'
        ";
    
        return $conn->query($query);
    }

}
