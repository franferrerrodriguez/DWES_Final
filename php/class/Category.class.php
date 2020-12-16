<?php

require_once('db/db.class.php');

class Category {
    
    private $id;
    private $name;
    private $description;
    private $isActive;
    private $categoryId;

    function __construct($name, $description, $isActive) {
        $this->name = $name;
        $this->description = $description;
        $this->isActive = $isActive;
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

    public function setActive($isActive) {
        $this->isActive = $isActive;
    }

    public function getActive() {
        return $this->isActive;
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

    static function countSubCategories($subcategory_id) {
        try {
            $records = null;
            $db = new DB();
            return $db->count("CATEGORIES", " WHERE category_id = $subcategory_id");
        } catch (PDOException $e) {
            echo "ERROR" . $e->getMessage();
        }
    }

    static function getById($categoryId) {
        try {
            $records = null;
            $db = new DB();
            if(!empty($db->conn)) {
                $stmt = $db->conn->prepare("SELECT * FROM CATEGORIES WHERE id = :categoryId");
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

    static function getBySubcategoryId($subCategoryId) {
        try {
            $records = null;
            $db = new DB();
            if(!empty($db->conn)) {
                $condition = $subCategoryId ? " = :subCategoryId" : " IS NULL";
                $stmt = $db->conn->prepare("SELECT * FROM CATEGORIES WHERE category_id $condition");
                $stmt->execute(array(
                    ':subCategoryId' => $subCategoryId
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
                    (:name, :description, :isActive);"
                );
        
                $stmt->execute(array(
                    ':name' => $this->name,
                    ':description' => $this->description,
                    ':isActive' => $this->isActive
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
                    SET name = :name, description = :description, is_active = :isActive
                    WHERE id LIKE :id"
                );
        
                $stmt->execute(array(
                    'id' => $this->id,
                    ':name' => $this->name,
                    ':description' => $this->description,
                    ':isActive' => $this->isActive
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