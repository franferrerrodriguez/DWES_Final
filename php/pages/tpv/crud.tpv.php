<?php

require_once('../../utils/globalFunctions.php');
require_once('../../class/Category.class.php');
require_once('../../class/ArticleCategory.class.php');

$action = $_GET["action"];
$id = $_GET["id"];

$result = [];
if($action === "categories") {
    $result = Category::getBySubcategoryId($id);
} else if($action === "articles") {
    $result = ArticleCategory::getArticlesByCategoryId($id);
}

echo json_encode_all($result);

?>