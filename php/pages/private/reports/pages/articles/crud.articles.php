<?php

require_once('../../../../../utils/globalFunctions.php');
require_once('../../../../../class/Article.class.php');

$action = $_POST["action"];

$result = [];
if($action == "articlesTable") {
    $articles = DB::query("A.id, A.name, A.img_route, A.brand, A.is_active, A.is_active, COUNT(OL.article_id) AS total",
                          "ARTICLES A LEFT JOIN ORDERLINES OL ON A.id = OL.article_id",
                          "GROUP BY A.id ORDER BY total DESC");

    foreach ($articles as $i => $article) {
        array_push($result, array(
            "id" => $article["id"],
            "name" => $article["name"],
            "brand" => $article["brand"],
            "is_active" => $article["is_active"],
            "total" => $article["total"]
        ));
    }
}

echo json_encode_all($result);
    
?>