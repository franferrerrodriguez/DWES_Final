<?php

require_once('../../../../../class/Article.class.php');
require_once('../../../../../class/ArticleCategory.class.php');
require_once('../../../../../utils/globalFunctions.php');

$action = $_REQUEST['action'];
$id = $_POST["id"];

if($action === "addEdit") {
    $serialNumber = $_POST['serialNumber'];
    $brand = replaceQuotes($_POST['brand']);
    $name = replaceQuotes($_POST['name']);
    $description = replaceQuotes($_POST['description']);
    $especification = replaceQuotes($_POST['especification']);
    $price = $_POST['price'];
    $priceDiscount = $_POST['priceDiscount'];
    $percentageDiscount = $_POST['percentageDiscount'];
    $isOutlet = $_POST['isOutlet'];
    $freeShipping = $_POST['freeShipping'];
    $stock = $_POST['stock'];
    $warranty = $_POST['warranty'];
    $returnDays = $_POST['returnDays'];
    $releaseDate = $_POST['releaseDate'];
    $isActive = $_POST['isActive'];
    $categories = $_POST['categories'];

    if(!$id) {
        try {
            $article = new Article($serialNumber, $brand, $name, $description, $especification, $price, $priceDiscount, 
                                   $isOutlet, $percentageDiscount, $freeShipping, $stock, $warranty, $returnDays, 
                                   $releaseDate, $isActive);
            $article->save();
            echo "OK";
        } catch (exception $e) {
            echo $e->getMessage();
        }
    } else {
        $article = Article::getById($id);
        $article->setSerialNumber($serialNumber);
        $article->setBrand($brand);
        $article->setName($name);
        $article->setDescription($description);
        $article->setEspecification($especification);
        $article->setPrice($price);
        $article->setPriceDiscount($priceDiscount);
        $article->setPercentageDiscount($percentageDiscount);
        $article->setOutlet($isOutlet);
        $article->setFreeShipping($freeShipping);
        $article->setStock($stock);
        $article->setWarranty($warranty);
        $article->setReturnDays($returnDays);
        $article->setReleaseDate($releaseDate);
        $article->setActive($isActive);

        ArticleCategory::deleteByArticleId($id);
        foreach ($categories as $index => $value) {
            $articleCategory = new ArticleCategory($id, $value);
            $articleCategory->save();
        }

        try {
            $article->update();
            echo "OK";
        } catch (exception $e) {
            echo $e->getMessage();
        }
    }
} else if($action === "delete") {
    try {
        // Article::delete($id);
        $article = Article::getById($id);
        $article->setActive(!$article->isActive());
        $article->update();
        echo "OK";
    } catch (exception $e) {
        echo $e->getMessage();
    }
} else if($action === "uploadImage" && isset($_FILES['file']['name'])) {
    // Getting file name
    $filename = $_FILES['file']['name'];
    
    // Location
    $locationDB = "assets/img/articles/" . $filename;
    $location = "../../../../../../assets/img/articles/" . $filename;
    $imageFileType = pathinfo($location,PATHINFO_EXTENSION);
    $imageFileType = strtolower($imageFileType);
    
    /* Valid extensions */
    $valid_extensions = array("jpg", "jpeg", "png");
    
    // Check file extension
    if(in_array(strtolower($imageFileType), $valid_extensions)) {
        // Upload file
        if(move_uploaded_file($_FILES['file']['tmp_name'], $location)) {
            $article = Article::getById($id);
            $article->setImgRoute($locationDB);

            try {
                $article->update();
                echo "OK";
            } catch (exception $e) {
                echo $e->getMessage();
            }
        }
    }
    
    exit;
}

?>