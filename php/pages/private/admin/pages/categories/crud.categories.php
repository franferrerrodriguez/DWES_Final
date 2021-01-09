<?php

require_once('../../../../../class/Category.class.php');

$action = $_REQUEST['action'];
$id = $_POST["id"];

if($action === "addEdit") {
    $name = $_POST["name"];
    $description = $_POST["description"];
    $is_active = $_POST["is_active"];
    $parentCategory = $_POST["parentCategory"];
    
    if(!$id) {
        try {
            $category = new Category($name, $description, $is_active, $parentCategory);
            $category->save();
            echo "OK";
        } catch (exception $e) {
            echo $e->getMessage();
        }
    } else {
        $category = Category::getById($id);
        $category->setName($name);
        $category->setDescription($description);
        $category->setActive($is_active);
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
        Category::delete($id);
        echo "OK";
    } catch (exception $e) {
        echo $e->getMessage();
    }
}

?>