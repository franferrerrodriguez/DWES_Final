<?php

require_once('ArticleCategory.class.php');

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
    private $isOutlet;
    private $freeShipping;
    private $stock;
    private $warranty;
    private $returnDays;
    private $visitorCounter;
    private $releaseDate;
    private $is_active;
    private $categories;

    function __construct($serialNumber, $brand, $name, $description, $especification, $imgRoute, $price, $priceDiscount, $isOutlet, $percentageDiscount, $freeShipping, $stock, $warranty, $returnDays, $visitorCounter, $releaseDate, $is_active, $categories = []) {
        $this->serialNumber = $serialNumber;
        $this->brand = $brand;
        $this->name = $name;
        $this->description = $description;
        $this->especification = $especification;
        $this->imgRoute = $imgRoute;
        $this->price = $price;
        $this->priceDiscount = $priceDiscount;
        $this->isOutlet = $isOutlet;
        $this->percentageDiscount = $percentageDiscount;
        $this->freeShipping = $freeShipping;
        $this->stock = $stock;
        $this->warranty = $warranty;
        $this->returnDays = $returnDays;
        $this->visitorCounter = $visitorCounter;
        $this->releaseDate = $releaseDate;
        $this->is_active = $is_active;
        $this->categories = $categories;
    }

    public function getId() {
        return $this->id;
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

    public function setOutlet($isOutlet) {
        $this->isOutlet = $isOutlet;
    }

    public function getOutlet() {
        return $this->isOutlet;
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

    public function setActive($is_active) {
        $this->is_active = $is_active;
    }

    public function isActive() {
        return $this->is_active;
    }

    public function setCategories($categories) {
        $this->categories = $categories;
    }

    public function setCategory($category) {
        array_push($this->categories, $category);
    }

    public function getCategories() {
        return $this->categories;
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

            foreach ($records as $index => $value) {
                $categories = ArticleCategory::getCategoriesByArticleId($value['id']);
                $records[$index]['categories'] = $categories;
            }

            return $records;
        } catch (PDOException $e) {
            echo "ERROR" . $e->getMessage();
        }
    }

    static function getById($id) {
        try {
            $records = null;
            $db = new DB();
            if(!empty($db->conn)) {
                $stmt = $db->conn->prepare("SELECT * FROM ARTICLES WHERE id = :id");
                $stmt->execute(array(
                    ':id' => $id
                ));
                $stmt->execute();
                $records = $stmt->fetchAll();
                if($records) {
                    $r = $records[0];
                    $object = new Article($r['serial_number'], $r['brand'], $r['name'], $r['description'], 
                        $r['especification'], $r['img_route'], $r['price'], $r['price_discount'], $r['is_outlet'], 
                        $r['percentage_discount'], $r['free_shipping'], $r['stock'], $r['warranty'], $r['return_days'], 
                        $r['visitor_counter'], $r['release_date'], $r['is_active']);

                        $categories = ArticleCategory::getCategoriesByArticleId($id);
                        $object->setCategories($categories);
                        
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

    static function delete($id) {
        try {
            $db = new DB();

            if(!empty($db->conn)) {
                $stmt = $db->conn->prepare(
                    "DELETE FROM ARTICLES WHERE id LIKE :id"
                );
        
                $stmt->execute(array(
                    ':id' => $id
                ));
            }

            $db->cerrarConn();
        } catch (PDOException $e) {
            echo "ERROR" . $e->getMessage();
        }
    }*/

}

?>