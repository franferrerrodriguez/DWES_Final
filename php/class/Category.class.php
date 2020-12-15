<?php

require_once('db/db.class.php');

class Category {
    
    private $id;
    private $name;
    private $description;
    private $isVisible;

    function __construct($name, $description, $isVisible) {
        $this->name = $name;
        $this->description = $description;
        $this->isVisible = $isVisible;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getName() {
        return $this->name;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setVisible($isVisible) {
        $this->isVisible = $isVisible;
    }

    public function isVisible() {
        return $this->isVisible;
    }

    static function getAll() {
        try {
            $records = null;
            $db = new DB();
            if(!empty($db->conn)) {
                $stmt = $db->conn->prepare("SELECT * from CATEGORIES;");
                $stmt->execute();
                $records = $stmt->fetchAll();
            }
            $db->cerrarConn();
            return $records;
        } catch (PDOException $e) {
            echo "ERROR" . $e->getMessage();
        }
    }

    static function getSubcategories($categoryId) {
        try {
            $records = null;
            $db = new DB();
            if(!empty($db->conn)) {
                $stmt = $db->conn->prepare("
                    SELECT B.*
                    FROM CATEGORIES A
                    RIGHT JOIN SUBCATEGORIES B
                    ON A.id = B.category_id
                    WHERE A.id = :categoryId;
                ");
                $stmt->execute(array(
                    ':categoryId' => $categoryId
                ));
                $stmt->execute();
                $records = $stmt->fetchAll();
            }
            $db->cerrarConn();
            return $records;
        } catch (PDOException $e) {
            echo "ERROR" . $e->getMessage();
        }
    }

    function save() {
        try {
            $db = new DB();

            if(!empty($db->conn)) {
                $stmt = $db->conn->prepare(
                    "INSERT INTO CATEGORIES(name, description, is_visible) VALUES
                    (:name, :description, :isVisible);"
                );
        
                $stmt->execute(array(
                    ':name' => $this->name,
                    ':description' => $this->description,
                    ':isVisible' => $this->isVisible
                ));
            }
            
            $db->cerrarConn();
        } catch (PDOException $e) {
            echo "ERROR" . $e->getMessage();
        }
    }

    function update() {
        try {
            $db = new DB();

            if(!empty($db->conn)) {
                $stmt = $db->conn->prepare(
                    "UPDATE CATEGORIES 
                    SET name = :name, description = :description, is_visible = :isVisible
                    WHERE id LIKE :id"
                );
        
                $stmt->execute(array(
                    'id' => $this->id,
                    ':name' => $this->name,
                    ':description' => $this->description,
                    ':isVisible' => $this->isVisible
                ));
            }

            $db->cerrarConn();
        } catch (PDOException $e) {
            echo "ERROR" . $e->getMessage();
        }
    }

    function delete() {
        try {
            $db = new DB();

            if(!empty($db->conn)) {
                $stmt = $db->conn->prepare(
                    "DELETE FROM CATEGORIES WHERE id LIKE :id"
                );
        
                $stmt->execute(array(
                    ':id' => $this->id
                ));
            }

            $db->cerrarConn();
        } catch (PDOException $e) {
            echo "ERROR" . $e->getMessage();
        }
    }

}

?>