<?php
require_once(__DIR__ . '/database.php');
require_once(__DIR__ . '/../controller/complaint_note.php');

class ComplaintNoteDB {

    public static function addNote($note) {

        $db = new Database();
        $conn = $db->getDbConn();
    
        $text = $conn->real_escape_string(
            $note->getNoteText()
        );
    
        $query = "
            INSERT INTO complaint_notes
            (complaint_id, user_id, note_text)
            VALUES (
                '{$note->getComplaintId()}',
                '{$note->getUserId()}',
                '$text'
            )
        ";
    
        return $conn->query($query);
    }

    public static function getNotesByComplaint($complaintId) {

        $db = new Database();
        $conn = $db->getDbConn();
    
        $query = "
            SELECT
                complaint_notes.*,
                users.full_name
            FROM complaint_notes
    
            JOIN users
                ON complaint_notes.user_id = users.user_id
    
            WHERE complaint_id = '$complaintId'
    
            ORDER BY created_at DESC
        ";
    
        $result = $conn->query($query);
    
        $rows = [];
    
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
    
        return $rows;
    }
}
