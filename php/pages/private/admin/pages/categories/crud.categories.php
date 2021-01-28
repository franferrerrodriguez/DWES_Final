<?php

require_once('../../../../../class/Category.class.php');

$action = $_REQUEST['action'];
$id = $_POST["id"];

if($action === "addEdit") {
    $name = $_POST["name"];
    $description = $_POST["description"];
    $isActive = $_POST["isActive"];
    $parentCategory = $_POST["parentCategory"];
    
    if(!$id) {
        try {
            $category = new Category($name, $description, $isActive, $parentCategory);
            $category->save();
            echo "OK";
        } catch (exception $e) {
            echo $e->getMessage();
        }
    } else {
        $category = Category::getById($id);
        $category->setName($name);
        $category->setDescription($description);
        $category->setActive($isActive);
        $category->setCategoryId($parentCategory);

        try {
            $category->update();
            echo "OK";
        } catch (exception $e) {
            echo $e->getMessage();
        }
    }
} else if($action === "delete") {
    try {
        // Category::delete($id);
        $category = Category::getById($id);
        $category->setActive(!$category->isActive());
        $category->update();
        echo "OK";
    } catch (exception $e) {
        echo $e->getMessage();
    }
}

?>