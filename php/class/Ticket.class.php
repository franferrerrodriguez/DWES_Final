<?php

require_once('db/db.class.php');

class Ticket {

    private $id;
    private $email;
    private $message;
    private $date;
    private $viewed;
    private $questioner;
    private $answerner;

    function __construct($email, $message, $date, $questioner, $answerner) {
        $this->email = $email;
        $this->message = $message;
        $this->date = $date;
        $this->viewed = 0;
        $this->questioner = $questioner;
        $this->answerner = $answerner;
    }

    public function getId() {
        return $this->id;
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

    public function setQuestioner($questioner) {
        $this->questioner = $questioner;
    }

    public function getQuestioner() {
        return $this->questioner;
    }

    public function setAnswerner($answerner) {
        $this->answerner = $answerner;
    }

    public function getAnswerner() {
        return $this->answerner;
    }

    static function getAll($condition = "", $orderBy = "date DESC") {
        $records = null;
        $db = new DB();
        if(!empty($db->conn)) {
            $stmt = $db->conn->prepare("SELECT * from TICKETS $condition ORDER BY $orderBy");
            $stmt->execute();
            $records = $stmt->fetchAll();
        }

        $objects = [];
        foreach ($records as $index => $r) {
            $object = new Ticket($r['email'], $r['message'], $r['date'], $r['viewed'], $r['questioner'], $r['answerner']);
            $object->id = $r['id'];
            array_push($objects, $object);
        }

        $db->cerrarConn();
        return $objects;
    }

    function save() {
        $db = new DB();

        if(!empty($db->conn)) {
            $stmt = $db->conn->prepare(
                "INSERT INTO TICKETS(email, message, date, viewed, questioner, answerner) VALUES
                (:email, :message, :date, :viewed, :questioner, :answerner)"
            );
    
            $stmt->execute(array(
                ':email' => $this->email,
                ':message' => $this->message,
                ':date' => $this->date,
                ':viewed' => $this->viewed,
                ':questioner' => $this->questioner,
                ':answerner' => $this->answerner
            ));
        }
        
        $db->cerrarConn();
    }

    static function getUserTickets($id) {
        $records = null;
        $db = new DB();

        if(!empty($db->conn)) {
            $stmt = $db->conn->prepare("SELECT * from TICKETS where questioner = :user ORDER BY date DESC");
            $stmt->execute(array(
                ':user' => $id
            ));
            $stmt->execute();
            $records = $stmt->fetchAll();
        }
        $db->cerrarConn();

        return $records;
    }

    static function getUserNotViewedTickets($id) {
        return DB::count("TICKETS", " WHERE questioner = $id AND viewed = 0");
    }

}