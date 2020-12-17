<?php $id = "addEdit"; ?>

<?php include('php/pages/common/open-modal-large.php'); ?>

<form>
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="inputEmail4">Nombre</label>
            <input type="email" class="form-control" id="inputEmail4" placeholder="Email">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="inputEmail4">Descripción</label>
            <input type="email" class="form-control" id="inputEmail4" placeholder="Email">
        </div>
    </div>


    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="inputState">Activo</label>
            <select id="inputState" class="form-control">
                <option selected>Choose...</option>
                <option>...</option>
            </select>
        </div>
        <div class="form-group col-md-6">
        <label for="inputState">Categoría padre</label>
            <select id="selectCategories" class="form-control"></select>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Aceptar</button>
</form>

<?php include('php/pages/common/close-modal-large.php'); ?>