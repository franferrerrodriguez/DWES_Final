<?php

echo $prueba;

?>

<div class="row">
    <?php
    for($i = 0; $i < 4; $i++) {
    ?>

    <!-- Article -->
    <div class="col-md-4">
        <div class="card mb-4 box-shadow boxarticle" onclick="window.location.href='?page=article-detail';" style="width:180px;">
            <img class="card-img-top" data-src="holder.js/100px225?theme=thumb&amp;bg=55595c&amp;fg=eceeef&amp;text=Thumbnail" alt="Thumbnail [100%x225]" style="height: 225px; width: 100%; display: block;" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22347%22%20height%3D%22225%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20347%20225%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_1766179e442%20text%20%7B%20fill%3A%23eceeef%3Bfont-weight%3Abold%3Bfont-family%3AArial%2C%20Helvetica%2C%20Open%20Sans%2C%20sans-serif%2C%20monospace%3Bfont-size%3A17pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_1766179e442%22%3E%3Crect%20width%3D%22347%22%20height%3D%22225%22%20fill%3D%22%2355595c%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%22116.203125%22%20y%3D%22120.103125%22%3EThumbnail%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" data-holder-rendered="true">
            <div class="card-body">
                <p class="article-text-primary">Título del artículo</p>
                <p class="article-text-price">0,00€</p>
                <p class="article-text-secundary">
                    <i class="fas fa-star"></i>
                    4.3
                    (178 Opiniones)
                </p>
                <div style="width:100%;height:10px;">
                    <a href="ok" class="btn btn-sm btn-outline-primary" role="button" aria-pressed="true">
                        <i class="fas fa-cart-plus"></i>
                        Añadir al carrito
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- End Article -->

    <?php
    }
    ?>
</div>