<?php
class User {
    private $userId;
    private $username;
    private $passwordHash;
    private $fullName;
    private $email;
    private $roleId;

    public function __construct($username, $passwordHash, $fullName, $email, $roleId) {
        $this->username = $username;
        $this->passwordHash = $passwordHash;
        $this->fullName = $fullName;
        $this->email = $email;
        $this->roleId = $roleId;
    }

    public function setUserId($id) { $this->userId = $id; }
    public function getUserId() { return $this->userId; }

    public function getUsername() { return $this->username; }
    public function getPasswordHash() { return $this->passwordHash; }
    public function getFullName() { return $this->fullName; }
    public function getEmail() { return $this->email; }
    public function getRoleId() { return $this->roleId; }
}
