<?php
require_once(__DIR__ . '/database.php');
require_once(__DIR__ . '/../controller/complaint_note.php');

class ComplaintNoteDB {

    public static function addNote($note) {
        $db = new Database();
        $conn = $db->getDbConn();

        $query = "INSERT INTO complaint_notes (complaint_id, user_id, note_text)
                  VALUES (
                    '{$note->getComplaintId()}',
                    '{$note->getUserId()}',
                    '{$conn->real_escape_string($note->getNoteText())}'
                  )";

        return $conn->query($query);
    }

    public static function getNotesByComplaint($complaintId) {
        $db = new Database();
        $conn = $db->getDbConn();

        $query = "SELECT n.*, u.full_name
                  FROM complaint_notes n
                  JOIN users u ON n.user_id = u.user_id
                  WHERE complaint_id = '$complaintId'
                  ORDER BY created_at ASC";
        $result = $conn->query($query);

        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }

        return $rows;
    }
}
