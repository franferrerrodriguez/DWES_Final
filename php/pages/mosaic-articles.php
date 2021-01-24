<?php
require_once("php/class/Article.class.php");
require_once("php/class/Category.class.php");

$search = null;
$category = null;
$condition = "";
if(isset($_REQUEST["search"])) {
    $search = $_REQUEST["search"];
    $condition = "WHERE ARTICLES.name LIKE '%" . $search . "%' OR ARTICLES.description LIKE '%" . $search . "%'";
} else if(isset($_REQUEST["category"])) {
    $category_id = $_REQUEST["category"];
    $category = Category::getById($category_id);
    $condition = "A LEFT JOIN ARTICLES_CATEGORIES B ON A.id = B.article_id WHERE B.category_id = " . $category_id;
} else if(isset($_REQUEST["releases"])) {
    $condition = "WHERE ARTICLES.release_date IS NOT NULL";
} else if(isset($_REQUEST["offers"])) {
    $condition = "WHERE ARTICLES.price_discount <> 0 OR ARTICLES.percentage_discount <> 0";
}
$condition .= " ORDER BY visitor_counter DESC";
?>

<h2>Listado de artículos</h2>
<hr/>
<?php
if(!is_null($search) && !empty($search)) {
    echo "<h5>Coincidencias: '" . $search . "':</h5>";
} else if(!is_null($category)) {
    echo "<h5>Familia: '" . $category->getName() . "':</h5>";
}
?>

<div class="row">
    <?php
    // Pagination Control
    $num_filas = 9;
    $pagination = $_GET["pagination"] ?? 1;
    $limit = ($pagination * $num_filas) - $num_filas;
    $total_articles =  DB::count("ARTICLES", $condition);
    $articles = Article::getAll("$condition LIMIT $limit, $num_filas");

    // Mosaic Articles
    foreach ($articles as $index => $article) {
        if($article['is_active']) {
            $price = $article['price'];
            $price_discount = $article['price_discount'];
            $percentage_discount = $article['percentage_discount'];
            if($price_discount) {
                $percentage_discount = round((100 - (($price_discount * 100) / $price)), 2);
            }
    ?>
            <!-- Article -->
            <div class="col-md-4" onclick="window.location.href='?page=article-detail/article-detail&id=<?php echo $article['id']; ?>'">
                <div class="card text-center card-article" style="width: 16rem;">
                    <div class="card-body">
                        <?php
                            $img_route = $article['img_route'] ? $article['img_route'] : 'assets/img/common/noimage.png';
                            if($price_discount || $percentage_discount) {
                                echo "<span style='float:left;font-size: 14px;' class='badge badge-danger'>-" . $percentage_discount . "%</span>";
                            }
                        ?>
                        <img class="card-img-top" src="<?php echo $img_route; ?>" style="width:172px;" data-holder-rendered="true">
                        <br>
                        <span class="card-article-title"><?php echo $article['name']; ?></span>
                        <br>
                        <?php
                            if($price_discount) {
                                echo "<span class='card-article-price-promotion-in'>" . $price_discount . "€</span>";
                                echo "&nbsp<span class='card-article-price-promotion-out'>" . $price . "€</span>";
                            } else if($percentage_discount) {
                                $price_discount = round(($price - (($price * $percentage_discount) / 100)), 2);
                                echo "<span class='card-article-price-promotion-in'>" . $price_discount . "€</span>";
                                echo "&nbsp<span class='card-article-price-promotion-out'>" . $price . "€</span>";
                            } else {
                                echo "<span class='card-article-price'>" . $article['price'] . "€</span>";
                            }
                            echo "<br>";
                            echo "<span class='card-article-text'>";
                                echo "<i class='fas fa-star'></i>";
                                echo "4.3 (178 Opiniones)";
                            echo "</span>";
                            if($article['stock'] > 0 && $article['free_shipping'] == 1) {
                                echo "<br>";
                                echo "<span class='badge badge-success'>Envío gratis</span>";   
                            }
                            if(!is_null($article['release_date'])) {
                                echo "<br>";
                                echo "<span class='badge badge-warning'>Próximamente: " . $article['release_date'] . "</span>";
                            } else if($article['stock'] == 0) {
                                echo "<br>";
                                echo "<span class='badge badge-danger'>Sin stock</span>";
                            } else {
                                echo "<br><a href='php/utils/shoppingCart.php?action=addItem&id=" . $article['id'] . "' class='btn btn-sm btn-outline-primary card-article-button' role='button' aria-pressed='true'>";
                                echo "<i class='fas fa-cart-plus'></i>Añadir al carrito";
                                echo "</a><br>";
                            }
                        ?>
                    </div>
                </div>
            </div>
            <!-- End Article -->
    <?php
        }
    }
    ?>
</div>

<!-- Pagination -->
<nav>
    <ul class="pagination">
        <?php
            $preUrl = "";
            $disabled = "disabled";
            if ($pagination > 1) {
                $prev = $pagination - 1;
                $preUrl = "?page=mosaic-articles&pagination=$prev";
                $disabled = "";
            }
            echo "<li class='page-item $disabled'><a class='page-link' href='$preUrl'>Anterior</a></li>";
            $total_pages = round($total_articles / $num_filas, 0, PHP_ROUND_HALF_UP);
            for($i = 1; $i < $total_pages + 1; $i++) {
                $active = $i == $pagination ? "active" : "";
                echo "<li class='page-item $active'><a class='page-link' href='?page=mosaic-articles&pagination=$i' >$i</a></li>";
            }
            $nextUrl = "";
            $disabled = "disabled";
            if ($pagination  < $total_pages) {
                $prox = $pagination + 1;
                $nextUrl = "?page=mosaic-articles&pagination=$prox";
                $disabled = "";
            }
            echo "<li class='page-item $disabled'><a class='page-link' href='$nextUrl'>Siguiente</a></li>";
        ?>

    </ul>
</nav>
<!-- End Pagination -->