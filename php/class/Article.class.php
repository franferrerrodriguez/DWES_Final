<?php

class Article {

    private $id;
    private $serialNumber;
    private $brand;
    private $name;
    private $description;
    private $especification;
    private $imgRoute;
    private $price;
    private $priceDiscount;
    private $percentageDiscount;
    private $freeShipping;
    private $stock;
    private $warranty;
    private $returnDays;
    private $isVisible;
    private $visitorCounter;
    private $releaseDate;
    private $subcategoryId;

    function __construct($serialNumber, $brand, $name, $description, $especification, $imgRoute, $price, $priceDiscount, $percentageDiscount, $freeShipping, $stock, $warranty, $returnDays, $isVisible, $visitorCounter, $releaseDate, $subcategoryId) {
        $this->serialNumber = $serialNumber;
        $this->brand = $brand;
        $this->name = $name;
        $this->description = $description;
        $this->especification = $especification;
        $this->imgRoute = $imgRoute;
        $this->price = $price;
        $this->priceDiscount = $priceDiscount;
        $this->percentageDiscount = $percentageDiscount;
        $this->freeShipping = $freeShipping;
        $this->stock = $stock;
        $this->warranty = $warranty;
        $this->returnDays = $returnDays;
        $this->isVisible = $isVisible;
        $this->visitorCounter = $visitorCounter;
        $this->releaseDate = $releaseDate;
        $this->subcategoryId = $subcategoryId;
    }

    public function setSerialNumber($serialNumber) {
        $this->serialNumber = $serialNumber;
    }

    public function getSerialNumber() {
        return $this->serialNumber;
    }

    public function setBrand($brand) {
        $this->brand = $brand;
    }

    public function getBrand() {
        return $this->brand;
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

    public function setEspecification($especification) {
        $this->especification = $especification;
    }

    public function getEspecification() {
        return $this->especification;
    }

    public function setImgRoute($imgRoute) {
        $this->imgRoute = $imgRoute;
    }

    public function getImgRoute() {
        return $this->imgRoute;
    }

    public function setPrice($price) {
        $this->price = $price;
    }

    public function getPrice() {
        return $this->price;
    }

    public function setPriceDiscount($priceDiscount) {
        $this->priceDiscount = $priceDiscount;
    }

    public function getPriceDiscount() {
        return $this->priceDiscount;
    }

    public function setPercentageDiscount($percentageDiscount) {
        $this->percentageDiscount = $percentageDiscount;
    }

    public function getPercentageDiscount() {
        return $this->percentageDiscount;
    }

    public function setFreeShipping($freeShipping) {
        $this->freeShipping = $freeShipping;
    }

    public function getFreeShipping() {
        return $this->freeShipping;
    }

    public function setStock($stock) {
        $this->stock = $stock;
    }

    public function getStock() {
        return $this->stock;
    }

    public function setWarranty($warranty) {
        $this->warranty = $warranty;
    }

    public function getWarranty() {
        return $this->warranty;
    }

    public function setReturnDays($returnDays) {
        $this->returnDays = $returnDays;
    }

    public function getReturnDays() {
        return $this->returnDays;
    }

    public function setVisible($isVisible) {
        $this->isVisible = $isVisible;
    }

    public function isVisible() {
        return $this->isVisible;
    }

    public function setVisitorCounter($visitorCounter) {
        $this->visitorCounter = $visitorCounter;
    }

    public function getVisitorCounter() {
        return $this->visitorCounter;
    }
    
    public function setReleaseDate($releaseDate) {
        $this->releaseDate = $releaseDate;
    }

    public function getReleaseDate() {
        return $this->releaseDate;
    }

    public function setSubcategoryId($subcategoryId) {
        $this->subcategoryId = $subcategoryId;
    }

    public function getSubcategoryId() {
        return $this->subcategoryId;
    }
    
    static function getAll() {
        try {
            $records = null;
            $db = new DB();
            if(!empty($db->conn)) {
                $stmt = $db->conn->prepare("SELECT * from ARTICLES;");
                $stmt->execute();
                $records = $stmt->fetchAll();
            }
            $db->cerrarConn();
            return $records;
        } catch (PDOException $e) {
            echo "ERROR" . $e->getMessage();
        }
    }

    /*function save() {
        try {
            $db = new DB();

            if(!empty($db->conn)) {
                $stmt = $db->conn->prepare(
                    "INSERT INTO ARTICLES(name, description, is_visible) VALUES
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
                    "UPDATE ARTICLES 
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
                    "DELETE FROM ARTICLES WHERE id LIKE :id"
                );
        
                $stmt->execute(array(
                    ':id' => $this->id
                ));
            }

            $db->cerrarConn();
        } catch (PDOException $e) {
            echo "ERROR" . $e->getMessage();
        }
    }*/

}

?>