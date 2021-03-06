<?php
require_once("php/class/User.class.php");
require_once("php/class/Article.class.php");
require_once("php/class/Review.class.php");

$user = User::getUserSession();
$article = Article::getById($_REQUEST['id']);
$reviews = Review::getByArticleId($article->getId());
$rating_average = Review::getAverageByArticleId($article->getId());

// Registramos una visita al artículo
$article->addVisit();

$price = $article->getPrice();
$price_discount = $article->getPriceDiscount();
$percentage_discount = $article->getPercentageDiscount();

if($price_discount) {
    $percentage_discount = round((100 - (($price_discount * 100) / $price)), 2);
}
?>

<h2>Detalles de artículo</h2>
<hr/>
<div class="row">
    <div class="col-5">
        <div class="HoverDiv">
            <?php
                $img_route = $article->getImgRoute() ? $article->getImgRoute() : 'assets/img/common/noimage.png';
            ?>
            <img onclick="window.open('<?php echo $article->getImgRoute(); ?>');" src="<?php echo $img_route; ?>" style="">
        </div>
    </div>
    <div class="col-7">
        <h4><?php echo $article->getName(); ?></h4>
        <br>
        <?php
        if($price_discount || $percentage_discount) {
            echo "<span class='badge badge-danger'>DESCUENTO</span><br>";
        }
        if($price_discount) {
            echo "<span class='detail-article-price-promotion-in'>" . $price_discount . "€</span>&nbsp";
            echo "<span class='detail-article-price-promotion-out'>" . $price . "€</span>";
        } else if($percentage_discount) {
            $price_discount = round(($price - (($price * $percentage_discount) / 100)), 2);
            echo "<span class='detail-article-price-promotion-in'>" . $price_discount . "€</span>&nbsp";
            echo "<span class='detail-article-price-promotion-out'>" . $price . "€</span>";
        } else {
            echo "<span class='detail-article-price'>" . $price . "€</span>";
        }
        ?>
        <br>

        <!-- Rating -->
        <div class="starrating starrating-small risingstar d-flex justify-content-end flex-row-reverse">
            <?php
                for($i = 5; $i > 0; $i--) {
                    $checked = $rating_average == $i ? "checked" : "";
                    echo "<input type='radio' id='star_a_$i' name='a_rating' value='$i' $checked disabled/><label for='star_a_$i' title='$i estrellas'></label>";
                }
            ?>
        </div>
        <?php echo count($reviews); ?> Opiniones | Reviews<br>
        
        <b>Cod. Artículo: </b><?php echo $article->getId(); ?><br>
        <b>Marca: </b><?php echo $article->getBrand(); ?><br>
        <b>S/N: </b><?php echo $article->getSerialNumber(); ?><br>

        <?php
        if($article->getStock() > 0 && $article->getFreeShipping() == 1) {
            echo "<span class='badge badge-success'>Envío gatis</span><br>";   
        }
        if($article->getStock() == 0) {
            echo "<span class='badge badge-danger'>Sin stock</span><br>";
        } else {
        ?>
            <span class='badge badge-success'>En stock</span><br>
            <br>
            
            <button type="button" class="btn btn-secondary" style="height:45px;width:45px;float:left;" onclick="if($('#quantity').val() > 1)$('#quantity').get(0).value--">-</button>
            <input type="number" id="quantity" class="form-control noSelectorNumber" value="1" style="height:45px;width:45px;float:left;margin-left:2px;margin-right:2px;">
            <button type="button" class="btn btn-secondary" style="height:45px;width:45px;float:left;" onclick="$('#quantity').get(0).value++">+</button>

            <br><br>
            <a onclick="addCartItem(<?php echo $article->getId(); ?>)" href="#" class="btn btn-success card-article-button" role="button" aria-pressed="true" style="width: 170px;">
                <i class="fas fa-cart-plus" aria-hidden="true"></i>
                Añadir al carrito
            </a>
            <a href="?page=shoppingCart" class="btn btn-primary card-article-button" role="button" aria-pressed="true" style="width: 170px;">
                <i class="fas fa-cart-arrow-down" aria-hidden="true"></i>
                Ver carrito
            </a>
            <br>
        <?php
        }
        ?>
        <br>
        <i class="fas fa-award fa-2x"></i>&nbsp<?php echo $article->getWarranty(); ?> años de garantía&nbsp
        <i class="fas fa-shield-alt fa-2x"></i>&nbspPago 100% seguro
        <br><br>
        Métodos de pago:<br>
        <i class="fas fa-credit-card fa-3x"></i>
        <i class="fab fa-cc-paypal fa-3x"></i>
        <i class="fab fa-google-pay fa-3x"></i>
        <i class="fab fa-cc-apple-pay fa-3x"></i>
    </div>
</div>
<?php
    if($article->getDescription()) {
        echo "<br><b>Descripción:</b><br>" . nl2br($article->getDescription()) . "<br>";
    }
?>
<hr/>
<br>
<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" data-toggle="pill" href="#especification" role="tab" aria-controls="especification" aria-selected="true">Especificaciones</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="pill" href="#reviews" role="tab" aria-controls="reviews" aria-selected="false">Opiniones</a>
    </li>
</ul>
<div class="tab-content" id="pills-tabContent">
    <div class="tab-pane fade show active" id="especification" role="tabpanel" aria-labelledby="pills-home-tab" style="font-weight: normal;">
        <?php echo nl2br($article->getEspecification()); ?>
    </div>
    <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="pills-profile-tab" style="font-weight: normal;">
        <?php
        // Escribir nueva reseña
        if(!$user) {
            echo "<h5>Acceda o regístrese para poder enviar una reseña.</h5><hr/>";
            echo "<a class='btn btn-primary' href='?page=login' role='button'>Ingresar</a>&nbsp";
            echo "<a class='btn btn-success' href='?page=register/register' role='button'>Registrarse</a>";
        } else {
        ?>
        <form id="reviews" class="was-validated">
            <hr/><h5>Escribir nueva reseña:</h5>
            <input type="hidden" id="id" value="<?php echo $article->getId(); ?>">
            <div class="form-group">
                <label for="exampleInputEmail1">Título (*):</label>
                <input type="text" class="form-control" id="title" placeholder="Título" required>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Descripción (*):</label>
                <textarea class="form-control" id="description" rows="4" placeholder="Descripción" required></textarea>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Puntuación (*):</label>
                <div class="starrating starrating-medium starrating-hover risingstar d-flex justify-content-end flex-row-reverse">
                    <input type="radio" id="star5" name="rating" value="5" /><label for="star5" title="5 estrellas"></label>
                    <input type="radio" id="star4" name="rating" value="4" /><label for="star4" title="4 estrellas"></label>
                    <input type="radio" id="star3" name="rating" value="3" /><label for="star3" title="3 estrellas"></label>
                    <input type="radio" id="star2" name="rating" value="2" /><label for="star2" title="2 estrellas"></label>
                    <input type="radio" id="star1" name="rating" value="1" checked/><label for="star1" title="1 estrellas"></label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Enviar</button>
            <button type="reset" class="btn btn-secondary">Borrar</button>
        </form>
        <?php
        }

        // Reseñas de otros usuarios
        if(count($reviews)) {
            echo "<br><hr/><h5>Reseñas de otros usuarios:</h5>";
            foreach ($reviews as $index => $review) {
                $user = User::getById($review->getUserId());
                echo "<div class='card'>";
                    echo "<h5 class='card-header'>[" . $review->getDate() . "] - " . $user->getFirstName() . "</h5>";
                    echo "<div class='card-body'>";
                        echo "<h5 class='card-title'>" . $review->getTitle() . "</h5>";
                        echo "<p class='card-text'>" . $review->getDescription() . "</p><hr/>";
                        echo "<div class='starrating starrating-small risingstar d-flex justify-content-end flex-row-reverse'>";
                            echo "(Puntuación: " . $review->getRating() . " / 5)";
                            for($i = 5; $i > 0; $i--) {
                                $checked = $review->getRating()== $i ? "checked" : "";
                                echo "<input type='radio' id='star$i" . $review->getId() . "' name='rating$i" . $review->getId(). "' value='$i' $checked disabled/><label for='star$i" . $review->getId() . "' title='$i estrellas'></label>";
                            }
                        echo "</div>";
                    echo "</div>";
                echo "</div><br>";
            }
        } else {
            echo "<br><hr/><h5>No existen reseñas de otros usuarios.</h5>";
        }
        ?>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#reviews').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                type: "POST",
                url: "php/pages/article-detail/send.review.php",
                data: { 
                    id: $('#id').val(),
                    title: $('#title').val(),
                    description: $('#description').val(),
                    rating: $('input[name=rating]:checked', '#reviews').val()
                },
                success: function(data) {
                    if(data === 'OK') {
                        location.reload();
                    } else {
                        $('#modaladdEdit').modal('toggle');
                        showAlert(data, "danger");
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    $('#modaladdEdit').modal('toggle');
                    showAlert("Ha ocurrido un error inesperado.", "danger");
                }
            });
        });
    });

    function addCartItem(articleId) {
        window.location.href = `php/utils/shoppingCart.php?action=addItem&id=${ articleId }&quantity=${ $('#quantity').val() }`;
    }
</script>