<?php

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

}

?>