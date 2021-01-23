<?php

require_once('db/db.class.php');

class Ticket {

    // Contact Types
    const RECEIVED = 0;
    const SENT = 1;

    private $id;
    private $issue;
    private $email;
    private $message;
    private $type;
    private $date;
    private $viewed;
    private $userId;

    function __construct($issue, $email, $message, $type, $date, $userId) {
        $this->issue = $issue;
        $this->email = $email;
        $this->message = $message;
        $this->type = $type;
        $this->date = $date;
        $this->viewed = 0;
        $this->userId = $userId;
    }

    public function getId() {
        return $this->id;
    }

    public function setIssue($issue) {
        $this->issue = $issue;
    }

    public function getIssue() {
        return $this->issue;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setMessage($message) {
        $this->message = $message;
    }

    public function getMessage() {
        return $this->message;
    }

    public function setViewed($viewed) {
        $this->viewed = $viewed;
    }

    public function getViewed() {
        return $this->viewed;
    }

    public function setDate($date) {
        $this->date = $date;
    }

    public function getDate() {
        return $this->date;
    }

    static function getAll($condition = "") {
        $records = null;
        $db = new DB();
        if(!empty($db->conn)) {
            $stmt = $db->conn->prepare("SELECT * from TICKETS $condition");
            $stmt->execute();
            $records = $stmt->fetchAll();
        }
        $db->cerrarConn();

        return $records;
    }

    static function getAllByUserId($id) {
        $records = null;
        $db = new DB();
        if(!empty($db->conn)) {
            $stmt = $db->conn->prepare("SELECT * from TICKETS where user_id = :userId");
            $stmt->execute(array(
                ':userId' => $id
            ));
            $stmt->execute();
            $records = $stmt->fetchAll();
        }
        $db->cerrarConn();

        foreach ($records as $index => $value) {
            $orderLines = OrderLine::getAllByOrderId($value['id']);
            $records[$index]['orderLines'] = $orderLines;
        }

        return $records;
    }

    function save() {
        $db = new DB();

        if(!empty($db->conn)) {
            $stmt = $db->conn->prepare(
                "INSERT INTO TICKETS(issue, email, message, type, date, viewed, user_id) VALUES
                (:issue, :email, :message, :type, :date, :viewed, :userId)"
            );
    
            $stmt->execute(array(
                ':issue' => $this->issue,
                ':email' => $this->email,
                ':message' => $this->message,
                ':type' => $this->type,
                ':date' => $this->date,
                ':viewed' => $this->viewed,
                ':userId' => $this->userId
            ));
        }
        
        $db->cerrarConn();
    }

}