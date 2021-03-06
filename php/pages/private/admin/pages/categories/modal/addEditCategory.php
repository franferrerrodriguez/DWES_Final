<?php $id = "addEdit"; ?>

<?php include('php/pages/common/open-modal-large.php'); ?>

<form id="form<?php echo $id; ?>" class="was-validated">
    <input type="hidden" id="id" value="">
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="name">Nombre</label>
            <input type="text" class="form-control" id="name" placeholder="Nombre" required>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="description">Descripción</label>
            <input type="text" class="form-control" id="description" placeholder="Descripción" required>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="isActive">Estado</label>
            <select id="isActive" class="form-control">
                <option value="1" selected>ACTIVO</option>
                <option value="0">INACTIVO</option>
            </select>
        </div>
        <div class="form-group col-md-6">
            <label for="parentCategoryId">Categoría padre</label>
            <select id="parentCategoryId" class="form-control">
                <option value="">Ninguno</option>
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

    <div id="modalAlert"></div>
    
    <button type="submit" id="button<?php echo $id; ?>" class="btn btn-primary">Aceptar</button>
</form>

<?php include('php/pages/common/close-modal-large.php'); ?>