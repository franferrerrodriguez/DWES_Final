<?php
require_once("php/class/Category.class.php");
$categories = Category::getAllMain();
?>

<div class="footer-sections">
    <div class="card-deck">
        <div class="card bg-light">
            <div class="card-header font-weight-bold">Menú principal</div>
            <div class="card-body">
                <a href="?page=index" class="card-link">Inicio</a><br>
                <a href="?page=tpv" class="card-link">TPV</a><br>
                <a href="?page=mosaic-articles&releases" class="card-link">Próximos artículos</a><br>
                <a href="?page=mosaic-articles&offers" class="card-link">Ofertas</a><br>
                <a href="?page=shipping/shippingOptions" class="card-link">Formas de envío</a><br>
                <a href="?page=shipping/returnPolitics" class="card-link">Políticas de devolución</a><br>
                <a href="?page=shipping/warranty" class="card-link">Garantía</a><br>
                <a href="?page=about" class="card-link">Quiénes somos</a><br>
                <a href="?page=terms" class="card-link">Términos y Condiciones</a><br>
                <a href="?page=tickets/tickets" class="card-link">Tickets</a>
            </div>
        </div>
        <div class="card bg-light">
            <div class="card-header font-weight-bold">Categorías</div>
            <div class="card-body">
                <?php
                foreach ($categories as $index => $category) {
                    echo "<a href='?page=mosaic-articles&category=" . $category->getId() . "' title='" . $category->getDescription() . "' class='card-link'>" . $category->getName() . "</a><br>";
                }  
                ?>
            </div>
        </div>
        <div class="card bg-light font-weight-bold">
            <div class="card-header">¿Necesitas ayuda?</div>
            <div class="card-body">
                <a class='btn btn-success' href='?page=tickets/tickets' role='button'>Enviar un ticket</a>
                <br><br><a class='btn btn-warning' href='?page=terms' role='button'>Términos y condiciones</a>
                <hr/><a href="mailto:franferrerrodriguez@gmail.com" class="card-link">franferrerrodriguez@gmail.com</a>
            </div>
        </div>
    </div>
</div>
<div class="footer-info">
    Tienda Online - Proyecto Final Desarrollo de Aplicaciones Web - Francisco José Ferrer Rodríguez - 2020-2021
</div>