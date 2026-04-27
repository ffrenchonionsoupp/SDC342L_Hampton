<?php
class Complaint {
    private $complaintId;
    private $userId;
    private $title;
    private $description;
    private $status;
    private $createdAt;
    private $updatedAt;

    public function __construct($userId, $title, $description, $status = 'open') {
        $this->userId = $userId;
        $this->title = $title;
        $this->description = $description;
        $this->status = $status;
    }

    public function setComplaintId($id) { $this->complaintId = $id; }
    public function getComplaintId() { return $this->complaintId; }

    public function getUserId() { return $this->userId; }
    public function getTitle() { return $this->title; }
    public function getDescription() { return $this->description; }
    public function getStatus() { return $this->status; }
}
