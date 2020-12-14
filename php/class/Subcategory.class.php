<?php

class Subcategory {
    
    private $id;
    private $name;
    private $description;
    private $category_id;

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

    public function setCategoryId($category_id) {
        $this->category_id = $category_id;
    }

    public function getCategoryId() {
        return $this->category_id;
    }

}

?>