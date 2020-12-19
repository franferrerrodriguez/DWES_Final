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
        $category = new Category($name, $description, $isActive, $parentCategory);
        $category->save();
    } else {
        $category = Category::getById($id);
        $category->setName($name);
        $category->setDescription($description);
        $category->setActive($isActive);
        $category->setCategoryId($parentCategory);
        $category->update();
    }
} else if($action === "delete") {
    Category::delete($id);
}

echo json_encode(["responseError" => false]);

?>