<?php
// getAllComplaints
// getComplaintsByUser
// getComplaintsByTechnician
// addComplaint
// updateComplaintStatus
// getComplaintDetails


require_once(__DIR__ . '/../model/database.php');
require_once(__DIR__ . '/../model/complaint_db.php');
require_once(__DIR__ . '/../model/complaint_assignment_db.php');
require_once(__DIR__ . '/../model/complaint_note_db.php');
require_once(__DIR__ . '/complaint.php');
require_once(__DIR__ . '/complaint_note.php');
require_once(__DIR__ . '/complaint_assignment.php');

class ComplaintController {

    public static function addComplaint(
        $userId,
        $title,
        $description,
        $uploadedFile = ''
    ) {
    
        // handle file upload
        if (!empty($_FILES['uploaded_file']['name'])) {
    
            $target_dir = __DIR__ . '/../uploads/';
    
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
    
            $filename = basename($_FILES['uploaded_file']['name']);
    
            $uploadedFile = time() . '_' . $filename;
            
            move_uploaded_file(
                $_FILES['uploaded_file']['tmp_name'],
                $target_dir . $uploadedFile
            );
        }
    
        $complaint = new Complaint(
            $userId,
            $title,
            $description,
            $uploadedFile
        );
    
        return ComplaintDB::addComplaint($complaint);
    }

    public static function getComplaintsForCustomer($userId) {
        return ComplaintDB::getComplaintsByUser($userId);
    }

    public static function getAllComplaints() {
        return ComplaintDB::getAllComplaints();
    }

    public static function getComplaintDetails($id) {
        $complaint = ComplaintDB::getComplaintById($id);
        $notes = ComplaintNoteDB::getNotesByComplaint($id);
        $assignment = ComplaintAssignmentDB::getAssignmentByComplaint($id);

        return [
            'complaint' => $complaint,
            'notes' => $notes,
            'assignment' => $assignment
        ];
    }
    public static function updateComplaint(
        $complaintId,
        $title,
        $description,
        $status
    ) {
    
        return ComplaintDB::updateComplaint(
            $complaintId,
            $title,
            $description,
            $status
        );
    }

    public static function assignComplaint($complaintId, $techId) {
        $assignment = new ComplaintAssignment($complaintId, $techId);
        ComplaintAssignmentDB::assignComplaint($assignment);
        ComplaintDB::updateStatus($complaintId, 'assigned');
    }

    public static function addNote($complaintId, $userId, $text) {
        $note = new ComplaintNote($complaintId, $userId, $text);
        return ComplaintNoteDB::addNote($note);
    }

    public static function getComplaintsForTechnician($techId) {
        return ComplaintAssignmentDB::getComplaintsByTechnician($techId);
    }

    public static function updateStatus($complaintId, $status) {
        return ComplaintDB::updateStatus($complaintId, $status);
    }
}
