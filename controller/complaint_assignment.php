// assignComplaint
// getAssignmentByComplaint
<?php
class ComplaintAssignment {
    private $assignmentId;
    private $complaintId;
    private $technicianId;

    public function __construct($complaintId, $technicianId) {
        $this->complaintId = $complaintId;
        $this->technicianId = $technicianId;
    }

    public function setAssignmentId($id) { $this->assignmentId = $id; }
    public function getAssignmentId() { return $this->assignmentId; }

    public function getComplaintId() { return $this->complaintId; }
    public function getTechnicianId() { return $this->technicianId; }
}
