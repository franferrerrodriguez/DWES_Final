<div class="row">
    <?php
    require_once("php/class/article.class.php");

    //echo $prueba;

    $articles = Article::getAll();

    foreach ($articles as $index => $article) {
        $price_discount = $article['price_discount'];
        $percentage_discount = $article['percentage_discount'];
    ?>

    <!-- Article -->
    <div class="col-md-4">
        <div class="card text-center card-article" style="width: 16rem;">
            <div class="card-body">
                <?php
                    if($price_discount || $percentage_discount) {
                        echo "<span class='badge badge-danger'>-20%</span>";
                    }
                ?>
                <img class="card-img-top" src="<?php echo $article['img_route']; ?>" style="width:172px;" data-holder-rendered="true">
                <br>
                <span class="card-article-title"><?php echo $article['name']; ?></span>
                <br>
                <?php
                    if($price_discount || $percentage_discount) {
                        echo "<span class='card-article-price-promotion-in'>" . $article['price'] . "€</span>";
                        echo "<span class='card-article-price-promotion-out'>" . $article['price'] . "€</span>";
                    } else {
                        echo "<span class='card-article-price'>" . $article['price'] . "€</span>";
                    }
                ?>
                <br>
                <span class="card-article-text">
                    <i class="fas fa-star"></i>
                    4.3
                    (178 Opiniones)
                </span>
                <br>
                <span class="badge badge-danger">No hay stock</span>

                <br>
                <span class="badge badge-success">Envío gatis</span>


                <br>
                <a href="ok" class="btn btn-sm btn-outline-primary card-article-button" role="button" aria-pressed="true">
                    <i class="fas fa-cart-plus"></i>
                    Añadir al carrito
                </a>
            </div>
        </div>
    </div>
    <!-- End Article -->

    <?php
    }
    ?>
</div>