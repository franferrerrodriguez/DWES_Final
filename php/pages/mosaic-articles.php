<h2>Listado de artículos</h2>
<hr/>
<div class="row">
    <?php
    require_once("php/class/Article.class.php");

    // Pagination Control
    $num_filas = 9;
    $pagination = $_GET["pagination"] ?? 1;
    $limit = ($pagination * $num_filas) - $num_filas;


    // HACER ESTO CON UN COUNT
    $total_articles = Article::getAll();



    $articles = Article::getAll("LIMIT $limit, $num_filas");

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
            <div class="col-md-4" onclick="window.location.href='?page=article-detail&id=<?php echo $article['id']; ?>'">
                <div class="card text-center card-article" style="width: 16rem;">
                    <div class="card-body">
                        <?php
                            if($price_discount || $percentage_discount) {
                                echo "<span style='float:left;font-size: 14px;' class='badge badge-danger'>-" . $percentage_discount . "%</span>";
                            }
                        ?>
                        <img class="card-img-top" src="<?php echo $article['img_route']; ?>" style="width:172px;" data-holder-rendered="true">
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
                                echo "<span class='badge badge-success'>Envío gatis</span>";   
                            }
                            if($article['stock'] == 0) {
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

    <!-- Pagination -->
    <nav>
        <ul class="pagination">
            <?php
                if ($pagination > 1) {
                    $prev = $pagination - 1;
                    $preUrl = "/?page=mosaic-articles&pagination=$prev";
                    echo "<li class='page-item'><a class='page-link' href='$preUrl'>Anterior</a></li>";
                }
                $total_pages = round(count($total_articles) / $num_filas, 0, PHP_ROUND_HALF_UP);
                for($i = 1; $i < $total_pages + 1; $i++) {
                    $active = $i == $pagination ? "active" : "";
                    echo "<li class='page-item $active'><a class='page-link' href='/?page=mosaic-articles&pagination=$i' >$i</a></li>";
                }
                if ($pagination  < $total_pages) {
                    $prox = $pagination + 1;
                    $nextUrl = "/?page=mosaic-articles&pagination=$prox";
                    echo "<li class='page-item'><a class='page-link' href='$nextUrl'>Siguiente</a></li>";
                }
            ?>

        </ul>
    </nav>
    <!-- End Pagination -->

</div>