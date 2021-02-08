<?php
require_once("php/class/Article.class.php");
require_once("php/class/Category.class.php");
require_once("php/class/Review.class.php");

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
    $condition = "WHERE ARTICLES.release_date IS NOT NULL AND ARTICLES.release_date NOT LIKE '0001-01-01'";
} else if(isset($_REQUEST["offers"])) {
    $condition = "WHERE ARTICLES.price_discount <> 0 OR ARTICLES.percentage_discount <> 0";
} else if(isset($_REQUEST["outlet"])) {
    $condition = "WHERE ARTICLES.is_outlet = 1";
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

// Pagination Control
$num_filas = 12;
$pagination = $_GET["pagination"] ?? 1;
$limit = ($pagination * $num_filas) - $num_filas;
$total_articles =  DB::count("ARTICLES", $condition);
$articles = Article::getAll("$condition LIMIT $limit, $num_filas");

if(!count($articles)) {
    echo "No existen artículos con los filtros seleccionados.<hr/>";
} else {
?>

<div class="row">
    <?php
    // Mosaic Articles
    foreach ($articles as $index => $article) {
        if($article->isActive()) {
            $reviews = Review::getByArticleId($article->getId());
            $rating_average = Review::getAverageByArticleId($article->getId());
            $price = $article->getPrice();
            $price_discount = $article->getPriceDiscount();
            $percentage_discount = $article->getPercentageDiscount();
            if($price_discount) {
                $percentage_discount = round((100 - (($price_discount * 100) / $price)), 2);
            }
    ?>
            <!-- Article -->
            <div class="col-md-3">
                <div class="card text-center card-article" style="width: 18rem;height:96%;margin:0 auto;">
                    <div class="card-body" onclick="window.location.href='?page=article-detail/article-detail&id=<?php echo $article->getId(); ?>'">
                        <?php
                            // Div Article Label
                            echo "<div style='height:25px;width:100%;'>";
                                if($price_discount || $percentage_discount) {
                                    echo "<span style='float:left;font-size: 14px;' class='badge badge-danger'>-" . $percentage_discount . "%</span>";
                                }
                                if($article->getStock() > 0 && $article->getFreeShipping() == 1) {
                                    echo "<span style='float:left;font-size: 14px;margin-left:10px;' class='badge badge-success'>Envío gratis</span>";   
                                }
                            echo "</div>";
                            // Div Article Label

                            $img_route = $article->getImgRoute() ? $article->getImgRoute() : 'assets/img/common/noimage.png';
                        ?>
                        <!-- Div Article Image -->
                        <div style="height:220px;width:100%;">
                            <img class="card-img-top" src="<?php echo $img_route; ?>" style="width:172px;" data-holder-rendered="true">
                        </div>
                        <!-- End Div Article Image -->

                        <!-- Div Article Name -->
                        <div style="height:90px;width:100%;">
                            <span class="card-article-title"><?php echo $article->getName(); ?></span>
                        </div>
                        <!-- End Div Article Name -->

                        <!-- Div Article Price -->
                        <div style="height:40px;width:100%;">
                            <?php
                            if($price_discount) {
                                echo "<span class='card-article-price-promotion-in'>" . $price_discount . "€</span>";
                                echo "&nbsp<span class='card-article-price-promotion-out'>" . $price . "€</span>";
                            } else if($percentage_discount) {
                                $price_discount = round(($price - (($price * $percentage_discount) / 100)), 2);
                                echo "<span class='card-article-price-promotion-in'>" . $price_discount . "€</span>";
                                echo "&nbsp<span class='card-article-price-promotion-out'>" . $price . "€</span>";
                            } else {
                                echo "<span class='card-article-price'>" . $article->getPrice() . "€</span>";
                            }
                            ?>
                        </div>
                        <!-- End Div Article Price -->

                        <?php
                            // Div Article Rating
                            echo "<div style='height:110px;width:100%;'>";
                                echo "<div class='starrating starrating-small risingstar d-flex justify-content-center flex-row-reverse'>";
                                    for($i = 5; $i > 0; $i--) {
                                        $checked = $rating_average == $i ? "checked" : "";
                                        echo "<input type='radio' id='star$i" . $article->getId() . "' name='rating$i" . $article->getId() . "' value='$i' $checked disabled/><label for='star$i" . $article->getId() . "' title='$i estrellas'></label>";
                                    }
                                echo "</div>";
                                echo "<span class='card-article-text'>";
                                    echo "<i class='fas fa-star'></i>&nbsp" . $rating_average . "/5 Estrellas";
                                    echo "<br>(" . count($reviews) . " Opiniones | Reviews)";
                                echo "</span>";
                            echo "</div>";
                            // End Div Article Rating

                            // Div Article Button
                            echo "<div style='height:50px;width:100%;'>";
                                if(!is_null($article->getReleaseDate()) && $article->getReleaseDate() !== "0001-01-01") {
                                    echo "<span class='badge badge-warning'>Próximamente: " . $article->getReleaseDate() . "</span>";
                                } else if($article->getStock() == 0) {
                                    echo "<span class='badge badge-danger'>Sin stock</span>";
                                } else {
                                    echo "<a href='php/utils/shoppingCart.php?action=addItem&id=" . $article->getId() . "' class='btn btn-sm btn-outline-primary' role='button' aria-pressed='true'>";
                                        echo "<i class='fas fa-cart-plus'></i>Añadir al carrito";
                                    echo "</a>";
                                }
                            echo "</div>";
                            // End Div Article Button
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
<?php
}
?>

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