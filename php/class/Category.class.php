<?php

require_once('db/db.class.php');

class Category {
    
    private $id;
    private $name;
    private $description;
    private $isActive;
    private $parentCategoryId;

    function __construct($name, $description, $isActive, $parentCategoryId) {
        $this->name = $name;
        $this->description = $description;
        $this->isActive = $isActive;
        $this->parentCategoryId = $parentCategoryId !== '' ? $parentCategoryId : null;
    }

    public function getId() {
        return $this->id;
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

    public function isActive() {
        return $this->isActive;
    }

    public function setCategoryId($parentCategoryId) {
        $this->parentCategoryId = $parentCategoryId !== '' ? $parentCategoryId : null;
    }

    public function getCategoryId() {
        return $this->parentCategoryId;
    }

    static function getAll() {
        try {
            $records = null;
            $db = new DB();
            if(!empty($db->conn)) {
                $stmt = $db->conn->prepare("SELECT * from CATEGORIES");
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

    static function getById($id) {
        try {
            $records = null;
            $db = new DB();
            if(!empty($db->conn)) {
                $stmt = $db->conn->prepare("SELECT * FROM CATEGORIES WHERE id = :id");
                $stmt->execute(array(
                    ':id' => $id
                ));
                $stmt->execute();
                $records = $stmt->fetchAll();
                if($records) {
                    $r = $records[0];
                    $object = new Category($r['name'], $r['description'], $r['is_active'], $r['category_id']);
                    $object->id = $id;
                    return $object;
                } else {
                    return null;
                }
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
                    "INSERT INTO CATEGORIES(name, description, is_active, category_id) VALUES
                    (:name, :description, :isActive, :parentCategoryId);"
                );
        
                $stmt->execute(array(
                    ':name' => $this->name,
                    ':description' => $this->description,
                    ':isActive' => $this->isActive,
                    'parentCategoryId' => $this->parentCategoryId
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
                    SET name = :name, description = :description, is_active = :isActive, category_id = :parentCategoryId
                    WHERE id LIKE :id"
                );
        
                $stmt->execute(array(
                    'id' => $this->id,
                    ':name' => $this->name,
                    ':description' => $this->description,
                    ':isActive' => $this->isActive,
                    'parentCategoryId' => $this->parentCategoryId
                ));
            }

            $db->cerrarConn();
        } catch (PDOException $e) {
            echo "ERROR" . $e->getMessage();
        }
    }

    static function delete($id) {
        try {
            $db = new DB();

            if(!empty($db->conn)) {
                $stmt = $db->conn->prepare(
                    "DELETE FROM CATEGORIES WHERE id LIKE :id"
                );
        
                $stmt->execute(array(
                    ':id' => $id
                ));
            }

            $db->cerrarConn();
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

}

?>