<?php
require_once("php/class/User.class.php");
$user = User::getUserSession();
?>

<h2>Mi cuenta</h2>

<hr/>

<form id="form" class="was-validated">
    <input type="hidden" id="id" value="<?php echo $user->getId(); ?>">
    <input type="hidden" id="rol" value="<?php echo $user->getRol(); ?>">
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" value="<?php echo $user->getEmail(); ?>" readonly>
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
            <label for="firstname">Nombre</label>
            <input type="text" class="form-control" id="firstname" placeholder="Nombre" value="<?php echo $user->getFirstName(); ?>" required <?php if($user->getRol() === '5') { echo 'disabled'; } ?>>
        </div>
        <div class="form-group col-md-4">
            <label for="first_lastname">Primer apellido</label>
            <input type="text" class="form-control" id="first_lastname" placeholder="Primer apellido" value="<?php echo $user->getFirstLastName(); ?>" <?php if($user->getRol() === '5') { echo 'disabled'; } ?>>
        </div>
        <div class="form-group col-md-4">
            <label for="second_lastname">Segundo apellido</label>
            <input type="text" class="form-control" id="second_lastname" placeholder="Segundo apellido" value="<?php echo $user->getSecondLastName(); ?>" <?php if($user->getRol() === '5') { echo 'disabled'; } ?>>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="document">Documento</label>
            <input type="text" class="form-control" id="document" placeholder="Documento" value="<?php echo $user->getDocument(); ?>" required <?php if($user->getRol() === '5') { echo 'disabled'; } ?>>
        </div>
        <div class="form-group col-md-4">
            <label for="phone1">Teléfono 1</label>
            <input type="number" class="form-control" id="phone1" placeholder="Teléfono 1" value="<?php echo $user->getPhone1(); ?>" required <?php if($user->getRol() === '5') { echo 'disabled'; } ?>>
        </div>
        <div class="form-group col-md-4">
            <label for="phone2">Teléfono 2</label>
            <input type="number" class="form-control" id="phone2" placeholder="Teléfono 2" value="<?php echo $user->getPhone2(); ?>" <?php if($user->getRol() === '5') { echo 'disabled'; } ?>>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-3">
            <label for="address">Dirección</label>
            <input type="text" class="form-control" id="address" placeholder="Dirección" value="<?php echo $user->getAddress(); ?>" required <?php if($user->getRol() === '5') { echo 'disabled'; } ?>>
        </div>
        <div class="form-group col-md-3">
            <label for="location">Población</label>
            <input type="text" class="form-control" id="location" placeholder="Población" value="<?php echo $user->getLocation(); ?>" required <?php if($user->getRol() === '5') { echo 'disabled'; } ?>>
        </div>
        <div class="form-group col-md-3">
            <label for="province">Provincia</label>
            <input type="text" class="form-control" id="province" placeholder="Provincia" value="<?php echo $user->getProvince(); ?>" required <?php if($user->getRol() === '5') { echo 'disabled'; } ?>>
        </div>
        <div class="form-group col-md-3">
            <label for="country">País</label>
            <input type="text" class="form-control" id="country" placeholder="País" value="<?php echo $user->getCountry(); ?>" required <?php if($user->getRol() === '5') { echo 'disabled'; } ?>>
        </div>
    </div>

    <div id="modalAlert"></div>

    <button type="submit" id="button<?php echo $id; ?>" class="btn btn-primary">Aceptar</button>
</form>

<script type="text/javascript">
    $(document).ready(function() {
        $('#form').on('submit', function(e) {
            let formValid = true;
            e.preventDefault();
            let user = getUser();

            // Comprobamos contraseñas
            if(user.password1 || user.password2) {
                if(user.password1 !== user.password2) {
                    formValid = false;
                    resetFields();
                    showAlert("Las contraseñas introducidas no coinciden. Por favor, vuelva a intentarlo.", "danger", "modalAlert");
                } else if(user.password1.length < 4) {
                    formValid = false;
                    resetFields();
                    showAlert("La longitud de la contraseña debe ser igual o superior a 4 dígitos.", "danger", "modalAlert");
                }
            } else if(!validateDocument(user.document) && user.rol !== '5') { // Validamos documento
                formValid = false;
                resetFields();
                showAlert("El número de documento no contiene un formato válido.", "danger", "modalAlert");
            }

            if(formValid) {
                $.ajax({
                    type: "POST",
                    url: "php/pages/private/my-account/crud.my-account.php",
                    data: user,
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
            }
        });
    });

    function getUser() {
        return {
            id: $('#id').val(),
            email: $('#email').val(),
            password1: $('#password1').val(),
            password2: $('#password2').val(),
            firstname: $('#firstname').val(),
            first_lastname: $('#first_lastname').val(),
            second_lastname: $('#second_lastname').val(),
            document: $('#document').val(),
            phone1: $('#phone1').val(),
            phone2: $('#phone2').val(),
            address: $('#address').val(),
            location: $('#location').val(),
            province: $('#province').val(),
            country: $('#country').val(),
            rol: $('#rol').val()
        }
    }

    function resetFields() {
        $('#password1').val('');
        $('#password2').val('');
        $('#modalAlert').html('');
    }
</script>