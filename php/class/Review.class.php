<?php

require_once('db/db.class.php');

class Review {

    private $id;
    private $title;
    private $description;
    private $rating;
    private $date;
    private $articleId;
    private $userId;

    function __construct($title, $description, $rating, $date, $articleId, $userId) {
        $this->title = $title;
        $this->description = $description;
        $this->rating = $rating;
        $this->date = $date;
        $this->articleId = $articleId;
        $this->userId = $userId;
    }

    public function getId() {
        return $this->id;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setRating($rating) {
        $this->rating = $rating;
    }

    public function getRating() {
        return $this->rating;
    }

    public function setDate($date) {
        $this->date = $date;
    }

    public function getDate() {
        return $this->date;
    }

    public function setArticleId($articleId) {
        $this->articleId = $articleId;
    }

    public function getArticleId() {
        return $this->articleId;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
    }

    public function getUserId() {
        return $this->userId;
    }

    static function getAll($condition = "") {
        $records = null;
        $db = new DB();
        if(!empty($db->conn)) {
            $stmt = $db->conn->prepare("SELECT * from REVIEWS $condition ORDER BY date DESC");
            $stmt->execute();
            $records = $stmt->fetchAll();
        }
        $db->cerrarConn();

        return $records;
    }

    static function getByArticleId($id) {
        $records = null;
        $db = new DB();

        if(!empty($db->conn)) {
            $stmt = $db->conn->prepare("SELECT * from REVIEWS WHERE article_id = $id ORDER BY date DESC");
            $stmt->execute(array(
                ':user' => $id
            ));
            $stmt->execute();
            $records = $stmt->fetchAll();
        }
        $db->cerrarConn();

        return $records;
    }

    function save() {
        $db = new DB();

        if(!empty($db->conn)) {
            $stmt = $db->conn->prepare(
                "INSERT INTO REVIEWS(title, description, rating, date, article_id, user_id) VALUES
                (:title, :description, :rating, :date, :articleId, :userId)"
            );
    
            $stmt->execute(array(
                ':title' => $this->title,
                ':description' => $this->description,
                ':rating' => $this->rating,
                ':date' => $this->date,
                ':articleId' => $this->articleId,
                ':userId' => $this->userId
            ));
        }
        
        $db->cerrarConn();
    }

    static function getAverageByArticleId($id) {
        $records = null;
        $db = new DB();

        if(!empty($db->conn)) {
            $stmt = $db->conn->prepare("SELECT * from REVIEWS WHERE article_id = $id ORDER BY date DESC");
            $stmt->execute(array(
                ':user' => $id
            ));
            $stmt->execute();
            $records = $stmt->fetchAll();

            $total = 0;
            foreach ($records as $index => $value) {
                $total += $value["rating"];
            }

            return count($records) ? round($total / count($records), 0, PHP_ROUND_HALF_DOWN) : 0;
        }
        $db->cerrarConn();

        return $records;
    }

}