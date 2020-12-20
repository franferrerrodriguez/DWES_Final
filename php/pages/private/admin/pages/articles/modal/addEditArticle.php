<?php 
require_once('php/class/Category.class.php');

$categories = Category::getAll();

$id = "addEdit";
?>

<?php include('php/pages/common/open-modal-large.php'); ?>

<form id="form<?php echo $id; ?>">
    <input type="hidden" id="id" value="">
    <div class="form-row">
        <div class="form-group col-md-4">
            <img src="/assets/img/common/noimage.png" alt="noimage" class="img-thumbnail" style="height:212px;">
            <div class="custom-file" style="margin-top:4px;">
                <input type="file" class="custom-file-input" id="customFile">
                <label class="custom-file-label" for="customFile">Subir imagen</label>
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
            <label for="serial_number">Número de serie</label>
            <input type="text" class="form-control" id="serial_number" placeholder="Número de serie">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="price">Precio</label>
            <input type="number" class="form-control" id="price" step="any" placeholder="Precio">
        </div>
        <div class="form-group col-md-4">
            <label for="price_discount">Precio con descuento</label>
            <input type="number" class="form-control" id="price_discount" step="any" placeholder="Precio con descuento">
        </div>
        <div class="form-group col-md-4">
            <label for="percentage_discount">Porcentaje descuento</label>
            <input type="number" class="form-control" id="percentage_discount" step="any" placeholder="Porcentaje descuento">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="is_outlet">Producto Outlet</label>
            <select id="is_outlet" class="form-control">
                <option value="0" selected>NO</option>
                <option value="1">SI</option>
            </select>
        </div>
        <div class="form-group col-md-4">
            <label for="free_shipping">Envío gratis</label>
            <select id="free_shipping" class="form-control">
                <option value="0" selected>NO</option>
                <option value="1">SI</option>
            </select>
        </div>
        <div class="form-group col-md-4">
            <label for="release_date">Fecha de lanzamiento</label>
            <input type="date" class="form-control" id="release_date" placeholder="Fecha de lanzamiento">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-3">
            <label for="warranty">Años garantía</label>
            <input type="number" class="form-control" id="warranty" placeholder="Años garantía">
        </div>
        <div class="form-group col-md-3">
            <label for="return_days">Días devolución</label>
            <input type="number" class="form-control" id="return_days" placeholder="Días devolución">
        </div>
        <div class="form-group col-md-3">
            <label for="stock">Stock</label>
            <input type="number" class="form-control" id="stock" placeholder="Stock">
        </div>
        <div class="form-group col-md-3">
            <label for="visitor_counter">Visitas</label>
            <input type="number" class="form-control" id="visitor_counter" placeholder="Visitas">
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
                            echo "<option value='" . $category['id'] . "'>" . $category['name'] . "</option>";
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
            <label for="is_active">Estado</label>
            <select id="is_active" class="form-control">
                <option value="1" selected>ACTIVO</option>
                <option value="0">INACTIVO</option>
            </select>
        </div>
    </div>

    <div id="modalAlert"></div>
    
    <button type="submit" id="button<?php echo $id; ?>" class="btn btn-primary">Aceptar</button>
</form>

<?php include('php/pages/common/close-modal-large.php'); ?>