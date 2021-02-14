<?php 
require_once("php/class/Category.class.php");

$categories = Category::getAll();

$id = "addEdit";
?>

<?php include('php/pages/common/open-modal-large.php'); ?>

<form id="form<?php echo $id; ?>" class="was-validated">
    <input type="hidden" id="id" value="">
    <div class="form-row">
        <div class="form-group col-md-4">
            <img id="img" src="assets/img/common/noimage.png" alt="noimage" class="img-thumbnail" style="height:212px;">
            <div class="custom-file" style="margin-top:4px;">
                <input type="file" class="custom-file-input" id="file" name="file" onchange="previewFile()">
                <label class="custom-file-label" for="file">Cargar imagen</label>
            </div>
        </div>
        <div class="form-group col-md-8">
            <label for="name">Nombre</label>
            <input type="text" class="form-control" id="name" placeholder="Nombre" required>

            <label for="description">Descripción</label>
            <textarea class="form-control" id="description" rows="4" placeholder="Descripción"></textarea>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="especification">Especificaciones</label>
            <textarea class="form-control" id="especification" rows="3" placeholder="Especificaciones"></textarea>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="brand">Marca</label>
            <input type="text" class="form-control" id="brand" placeholder="Marca" required>
        </div>
        <div class="form-group col-md-8">
            <label for="serialNumber">Número de serie</label>
            <input type="text" class="form-control" id="serialNumber" placeholder="Número de serie">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="price">Precio</label>
            <input type="number" class="form-control" id="price" step="any" placeholder="Precio">
        </div>
        <div class="form-group col-md-4">
            <label for="priceDiscount">Precio con descuento</label>
            <input type="number" class="form-control" id="priceDiscount" step="any" placeholder="Precio con descuento">
        </div>
        <div class="form-group col-md-4">
            <label for="percentageDiscount">Porcentaje descuento</label>
            <input type="number" class="form-control" id="percentageDiscount" step="any" placeholder="Porcentaje descuento">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="isOutlet">Producto Outlet</label>
            <select id="isOutlet" class="form-control">
                <option value="0" selected>NO</option>
                <option value="1">SI</option>
            </select>
        </div>
        <div class="form-group col-md-4">
            <label for="freeShipping">Envío gratis</label>
            <select id="freeShipping" class="form-control">
                <option value="0" selected>NO</option>
                <option value="1">SI</option>
            </select>
        </div>
        <div class="form-group col-md-4">
            <div class="custom-control custom-checkbox mb-3">
                <input type="checkbox" class="custom-control-input" id="releaseDateValidation" required>
                <label class="custom-control-label" for="releaseDateValidation">Fecha de lanzamiento</label>
                <input type="date" class="valid-feedback form-control" id="releaseDate" placeholder="Fecha de lanzamiento" style="margin-left:-20px;margin-top:8px;height:38px;">
            </div>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-3">
            <label for="warranty">Años garantía</label>
            <input type="number" class="form-control" id="warranty" placeholder="Años garantía">
        </div>
        <div class="form-group col-md-3">
            <label for="returnDays">Días devolución</label>
            <input type="number" class="form-control" id="returnDays" placeholder="Días devolución">
        </div>
        <div class="form-group col-md-3">
            <label for="stock">Stock</label>
            <input type="number" class="form-control" id="stock" placeholder="Stock">
        </div>
        <div class="form-group col-md-3">
            <label for="visitorCounter">Contador de visitas</label>
            <input type="number" class="form-control" id="visitorCounter" placeholder="Contador de visitas" readonly>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-5">
            <label for="categories">Categorías</label>
            <div id="divSelectCategories">
                <select id="categories_0" class="form-control">
                    <?php
                    if($categories) {
                        foreach ($categories as $i => $category) {
                            echo "<option value='" . $category->getId() . "'>" . $category->getName() . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group col-md-2">
            <button type="button" class="btn btn-success btn-sm" style="margin-top:32px;height:37px;width:37px;" onclick="addSelectCategory()">
                <i class="fas fa-plus-circle"></i>
            </button>
            <button type="button" class="btn btn-danger btn-sm" style="margin-top:32px;height:37px;width:37px;" onclick="deleteSelectCategory()">
                <i class="fas fa-minus-circle"></i>
            </button>
        </div>
        <div class="form-group col-md-5">
            <label for="isActive">Estado</label>
            <select id="isActive" class="form-control">
                <option value="1" selected>ACTIVO</option>
                <option value="0">INACTIVO</option>
            </select>
        </div>
    </div>

    <div id="modalAlert"></div>
    
    <button type="submit" id="button<?php echo $id; ?>" class="btn btn-primary">Aceptar</button>
</form>

<?php include('php/pages/common/close-modal-large.php'); ?>