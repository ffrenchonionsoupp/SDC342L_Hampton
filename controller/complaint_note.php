<?php
class ComplaintNote {
    private $noteId;
    private $complaintId;
    private $userId;
    private $noteText;

    public function __construct($complaintId, $userId, $noteText) {
        $this->complaintId = $complaintId;
        $this->userId = $userId;
        $this->noteText = $noteText;
    }

    public function setNoteId($id) { $this->noteId = $id; }
    public function getNoteId() { return $this->noteId; }

    public function getComplaintId() { return $this->complaintId; }
    public function getUserId() { return $this->userId; }
    public function getNoteText() { return $this->noteText; }
}
