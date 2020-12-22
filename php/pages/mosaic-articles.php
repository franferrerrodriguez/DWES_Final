<h2>Listado de artículos</h2>
<hr/>
<div class="row">
    <?php
    require_once("php/class/article.class.php");

    //echo $prueba;

    $articles = Article::getAll();

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
                                echo "<span style='float:left;font-size: 14px;' class='badge badge-danger'>-" . $percentage_discount . "%</span><br>";
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
                            if($article['stock'] == 0) {
                                echo "<br>";
                                echo "<span class='badge badge-danger'>Sin stock</span>";
                            }
                            if($article['stock'] > 0 && $article['free_shipping'] == 1) {
                                echo "<br>";
                                echo "<span class='badge badge-success'>Envío gatis</span>";   
                            }
                        ?>
                        <br>
                        <a href="php/utils/shoppingCart.php?action=addItem&id=<?php echo $article['id']; ?>" class="btn btn-sm btn-outline-primary card-article-button" role="button" aria-pressed="true">
                            <i class="fas fa-cart-plus"></i>
                            Añadir al carrito
                        </a>
                    </div>
                </div>
            </div>
            <!-- End Article -->
    <?php
        }
    }
    ?>
</div>