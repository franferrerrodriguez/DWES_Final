<?php
require_once("php/class/Article.class.php");

$article = Article::getById($_REQUEST['id']);

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
            <img onclick="window.open('<?php echo $article->getImgRoute(); ?>');" src="<?php echo $article->getImgRoute(); ?>" style="">
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

        <!-- Stars -->
        <input id="radio1" type="radio" value="5">
        <label class='in' for="radio1">★</label>
        <input id="radio2" type="radio" value="4">
        <label class='in' for="radio2">★</label>
        <input id="radio3" type="radio" value="3">
        <label class='in' for="radio3">★</label>
        <input id="radio4" type="radio" value="2">
        <label class='in' for="radio4">★</label>
        <input id="radio5" type="radio" value="1">
        <label class='in' for="radio5">★</label>
        1000 Opiniones | Reviews<br>
        
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
        for($i = 0; $i < 5; $i++) {
        ?>
            <div class="card">
                <h5 class="card-header">Featured</h5>
                <div class="card-body">
                    <h5 class="card-title">Special title treatment</h5>
                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
            <br>
        <?php
        }
        ?>
    </div>
</div>

<script type="text/javascript">
    function addCartItem(articleId) {
        window.location.href = `php/utils/shoppingCart.php?action=addItem&id=${ articleId }&quantity=${ $('#quantity').val() }`;
    }
</script>