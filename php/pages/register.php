<?php
require_once("php/class/User.class.php");
$user = User::getUserSession();
?>

<h2>Registro</h2>

<hr/>

<form id="form">
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" placeholder="Email" required>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="password1">Contraseña</label>
            <input type="password" class="form-control" id="password1" placeholder="Contraseña" autocomplete="new-password" required>
        </div>
        <div class="form-group col-md-6">
            <label for="password2">Repite contraseña</label>
            <input type="password" class="form-control" id="password2" placeholder="Repite contraseña" autocomplete="new-password" required>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="firstname">Nombre</label>
            <input type="text" class="form-control" id="firstname" placeholder="Nombre" required>
        </div>
        <div class="form-group col-md-4">
            <label for="first_lastname">Primer apellido</label>
            <input type="text" class="form-control" id="first_lastname" placeholder="Primer apellido">
        </div>
        <div class="form-group col-md-4">
            <label for="second_lastname">Segundo apellido</label>
            <input type="text" class="form-control" id="second_lastname" placeholder="Segundo apellido">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="document">Documento</label>
            <input type="text" class="form-control" id="document" placeholder="Documento" required>
        </div>
        <div class="form-group col-md-4">
            <label for="phone1">Teléfono 1</label>
            <input type="number" class="form-control" id="phone1" placeholder="Teléfono 1">
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
            }

            if(formValid) {
                alert("ok");
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
            country: $('#country').val()
        }
    }

    function resetFields() {
        $('#password1').val('');
        $('#password2').val('');
        $('#modalAlert').html('');
    }
</script>