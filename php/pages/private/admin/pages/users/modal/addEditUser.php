<?php $id = "addEdit"; ?>

<?php include('php/pages/common/open-modal-large.php'); ?>

<form id="form<?php echo $id; ?>" class="was-validated">
    <input type="hidden" id="id" value="">
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" placeholder="Email">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="password1">Contraseña</label>
            <input type="password" class="form-control" id="password1" placeholder="Contraseña" autocomplete="new-password">
        </div>
        <div class="form-group col-md-6">
            <label for="password2">Repite contraseña</label>
            <input type="password" class="form-control" id="password2" placeholder="Repite contraseña" autocomplete="new-password">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="firstName">Nombre</label>
            <input type="text" class="form-control" id="firstName" placeholder="Nombre" required>
        </div>
        <div class="form-group col-md-4">
            <label for="firstLastName">Primer apellido</label>
            <input type="text" class="form-control" id="firstLastName" placeholder="Primer apellido" required>
        </div>
        <div class="form-group col-md-4">
            <label for="secondLastName">Segundo apellido</label>
            <input type="text" class="form-control" id="secondLastName" placeholder="Segundo apellido" required>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="document">Documento</label>
            <input type="text" class="form-control" id="document" placeholder="Documento" required>
        </div>
        <div class="form-group col-md-4">
            <label for="phone1">Teléfono 1</label>
            <input type="number" class="form-control" id="phone1" placeholder="Teléfono 1" required>
        </div>
        <div class="form-group col-md-4">
            <label for="phone2">Teléfono 2</label>
            <input type="number" class="form-control" id="phone2" placeholder="Teléfono 2">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-3">
            <label for="address">Dirección</label>
            <input type="text" class="form-control" id="address" placeholder="Dirección">
        </div>
        <div class="form-group col-md-3">
            <label for="location">Población</label>
            <input type="text" class="form-control" id="location" placeholder="Población">
        </div>
        <div class="form-group col-md-3">
            <label for="province">Provincia</label>
            <input type="text" class="form-control" id="province" placeholder="Provincia">
        </div>
        <div class="form-group col-md-3">
            <label for="country">País</label>
            <input type="text" class="form-control" id="country" placeholder="País">
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
            <label for="rol">Rol</label>
            <select id="rol" class="form-control">
                <option value="0" selected>CLIENTE</option>
                <option value="1">EMPLEADO</option>
                <option value="5">ADMINISTRADOR</option>
            </select>
        </div>
    </div>

    <div id="modalAlert"></div>

    <button type="submit" id="button<?php echo $id; ?>" class="btn btn-primary">Aceptar</button>
</form>

<?php include('php/pages/common/close-modal-large.php'); ?>