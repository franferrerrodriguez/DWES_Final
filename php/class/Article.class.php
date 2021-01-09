<?php

require_once('db/db.class.php');
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
    private $isActive;
    private $categories;

    function __construct($serialNumber, $brand, $name, $description, $especification, $price, $priceDiscount, $isOutlet, $percentageDiscount, $freeShipping, $stock, $warranty, $returnDays, $releaseDate, $isActive) {
        $this->serialNumber = $serialNumber;
        $this->brand = $brand;
        $this->name = $name;
        $this->description = $description;
        $this->especification = $especification;
        $this->imgRoute = '';
        $this->price = $price;
        $this->priceDiscount = $priceDiscount;
        $this->isOutlet = $isOutlet;
        $this->percentageDiscount = $percentageDiscount;
        $this->freeShipping = $freeShipping;
        $this->stock = $stock;
        $this->warranty = $warranty;
        $this->returnDays = $returnDays;
        $this->visitorCounter = 0;
        $this->releaseDate = $releaseDate;
        $this->isActive = $isActive;
        $this->categories = [];
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

    public function setActive($isActive) {
        $this->isActive = $isActive;
    }

    public function isActive() {
        return $this->isActive;
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
    
    static function getAll($condition = "") {
        $records = null;
        $db = new DB();
        if(!empty($db->conn)) {
            $stmt = $db->conn->prepare("SELECT * from ARTICLES $condition");
            $stmt->execute();
            $records = $stmt->fetchAll();
        }
        $db->cerrarConn();

        foreach ($records as $index => $value) {
            $categories = ArticleCategory::getCategoriesByArticleId($value['id']);
            $records[$index]['categories'] = $categories;
        }

        return $records;
    }

    static function getById($id) {
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
                    $r['especification'], $r['price'], $r['price_discount'], $r['is_outlet'], 
                    $r['percentage_discount'], $r['free_shipping'], $r['stock'], $r['warranty'], $r['return_days'], 
                    $r['release_date'], $r['is_active']);

                $object->id = $id;
                $object->setImgRoute($r['img_route']);

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
    }
    
    function save() {
        $db = new DB();

        if(!empty($db->conn)) {
            $stmt = $db->conn->prepare(
                "INSERT INTO ARTICLES(serial_number, brand, name, description, especification, img_route, 
                price, price_discount, percentage_discount, is_outlet, free_shipping, stock, warranty, 
                return_days, visitor_counter, release_date, is_active) VALUES
                (:serialNumber, :brand, :name, :description, :especification, :imgRoute, :price, :priceDiscount, 
                :percentageDiscount, :isOutlet, :freeShipping, :stock, :warranty, :returnDays, :visitorCounter, :releaseDate, :isActive)"
            );
    
            $stmt->execute(array(
                ':serialNumber' => $this->serialNumber,
                ':brand' => $this->brand,
                ':name' => $this->name,
                ':description' => $this->description,
                ':especification' => $this->especification,
                ':imgRoute' => $this->imgRoute,
                ':price' => $this->price,
                ':priceDiscount' => $this->priceDiscount,
                ':percentageDiscount' => $this->percentageDiscount,
                ':isOutlet' => $this->isOutlet,
                ':freeShipping' => $this->freeShipping,
                ':stock' => $this->stock,
                ':warranty' => $this->warranty,
                ':returnDays' => $this->returnDays,
                ':visitorCounter' => $this->visitorCounter,
                ':releaseDate' => $this->releaseDate,
                ':isActive' => $this->isActive
            ));
        }
        
        $db->cerrarConn();
    }

    function update() {
        $db = new DB();

        if(!empty($db->conn)) {
            $stmt = $db->conn->prepare(
                "UPDATE ARTICLES 
                SET serial_number = :serialNumber, brand = :brand, name = :name, description = :description, 
                especification = :especification, img_route = :imgRoute, price = :price, price_discount = :priceDiscount, 
                percentage_discount = :percentageDiscount, is_outlet = :isOutlet, free_shipping = :freeShipping, 
                stock = :stock, warranty = :warranty, return_days = :returnDays, visitor_counter = :visitorCounter, 
                release_date = :releaseDate, is_active = :isActive
                WHERE id LIKE :id"
            );
    
            $stmt->execute(array(
                ':id' => $this->id,
                ':serialNumber' => $this->serialNumber,
                ':brand' => $this->brand,
                ':name' => $this->name,
                ':description' => $this->description,
                ':especification' => $this->especification,
                ':imgRoute' => $this->imgRoute,
                ':price' => $this->price,
                ':priceDiscount' => $this->priceDiscount,
                ':percentageDiscount' => $this->percentageDiscount,
                ':isOutlet' => $this->isOutlet,
                ':freeShipping' => $this->freeShipping,
                ':stock' => $this->stock,
                ':warranty' => $this->warranty,
                ':returnDays' => $this->returnDays,
                ':visitorCounter' => $this->visitorCounter,
                ':releaseDate' => $this->releaseDate,
                ':isActive' => $this->isActive
            ));
        }

        $db->cerrarConn();
    }

    static function delete($id) {
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
    }

}

?>