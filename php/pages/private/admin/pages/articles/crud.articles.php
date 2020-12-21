<?php

require_once('../../../../../class/Article.class.php');
require_once('../../../../../class/ArticleCategory.class.php');

$action = $_REQUEST['action'];
$id = $_POST["id"];

if($action === "addEdit") {
    $serial_number = $_POST['serial_number'];
    $brand = $_POST['brand'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $especification = $_POST['especification'];
    //$img_route = $_POST['img_route'];
    $img_route = '';
    $price = $_POST['price'];
    $price_discount = $_POST['price_discount'];
    $percentage_discount = $_POST['percentage_discount'];
    $is_outlet = $_POST['is_outlet'];
    $free_shipping = $_POST['free_shipping'];
    $stock = $_POST['stock'];
    $warranty = $_POST['warranty'];
    $return_days = $_POST['return_days'];
    $release_date = $_POST['release_date'];
    $is_active = $_POST['is_active'];
    $categories = $_POST['categories'];

    if(!$id) {
        $article = new Article($serial_number, $brand, $name, $description, $especification, $img_route, $price, $price_discount, 
        $is_outlet, $percentage_discount, $free_shipping, $stock, $warranty, $return_days, $release_date, $is_active);
        $article->save();
    } else {
        $article = Article::getById($id);
        $article->setSerialNumber($serial_number);
        $article->setBrand($brand);
        $article->setName($name);
        $article->setDescription($description);
        $article->setEspecification($especification);
        //$article->setImgRoute($img_route);
        $article->setPrice($price);
        $article->setPriceDiscount($price_discount);
        $article->setOutlet($percentage_discount);
        $article->setPercentageDiscount($is_outlet);
        $article->setFreeShipping($free_shipping);
        $article->setStock($stock);
        $article->setWarranty($warranty);
        $article->setReturnDays($return_days);
        $article->setReleaseDate($release_date);
        $article->setActive($is_active);

        ArticleCategory::deleteByArticleId($id);
        foreach ($categories as $index => $value) {
            $articleCategory = new ArticleCategory($id, $value);
            $articleCategory->save();
        }

        $article->update();
    }
} else if($action === "delete") {
    Article::delete($id);
}

echo json_encode(["responseError" => false]);

?>