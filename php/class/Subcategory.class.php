<?php

require_once('db/db.class.php');

class Subcategory {
    
    private $id;
    private $name;
    private $description;
    private $categoryId;

    function __construct($name, $description, $isVisible, $category_id) {
        $this->name = $name;
        $this->description = $description;
        $this->isVisible = $isVisible;
        $this->category_id = $category_id;
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

    public function setCategoryId($categoryId) {
        $this->categoryId = $categoryId;
    }

    public function getCategoryId() {
        return $this->categoryId;
    }

    static function getAll() {
        try {
            $records = null;
            $db = new DB();
            if(!empty($db->conn)) {
                $stmt = $db->conn->prepare("SELECT * from SUBCATEGORIES;");
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
                    "INSERT INTO SUBCATEGORIES(name, description, is_visible, category_id) VALUES
                    (:name, :description, :isVisible, :categoryId);"
                );
        
                $stmt->execute(array(
                    ':name' => $this->name,
                    ':description' => $this->description,
                    ':isVisible' => $this->isVisible,
                    ':categoryId' => $this->categoryId
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
                    "UPDATE SUBCATEGORIES 
                    SET name = :name, description = :description, is_visible = :isVisible, category_id = :categoryId
                    WHERE id LIKE :id"
                );
        
                $stmt->execute(array(
                    'id' => $this->id,
                    ':name' => $this->name,
                    ':description' => $this->description,
                    ':isVisible' => $this->isVisible,
                    ':categoryId' => $this->categoryId
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
                    "DELETE FROM SUBCATEGORIES WHERE id LIKE :id"
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