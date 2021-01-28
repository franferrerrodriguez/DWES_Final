<?php
require_once("php/class/User.class.php");
$user = User::getUserSession();
?>

<h2>Registro</h2>

<hr/>

<form id="form" class="was-validated">
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="password1">Contraseña</label>
            <input type="password" class="form-control" id="password1" name="password1" placeholder="Contraseña" autocomplete="new-password" required>
        </div>
        <div class="form-group col-md-6">
            <label for="password2">Repite contraseña</label>
            <input type="password" class="form-control" id="password2" name="password2" placeholder="Repite contraseña" autocomplete="new-password" required>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="firstname">Nombre</label>
            <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Nombre" required>
        </div>
        <div class="form-group col-md-4">
            <label for="first_lastname">Primer apellido</label>
            <input type="text" class="form-control" id="first_lastname" name="first_lastname" placeholder="Primer apellido" required>
        </div>
        <div class="form-group col-md-4">
            <label for="second_lastname">Segundo apellido</label>
            <input type="text" class="form-control" id="second_lastname" name="second_lastname" placeholder="Segundo apellido" required>
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="document">Documento</label>
            <input type="text" class="form-control" id="document" name="document" placeholder="Documento" required>
        </div>
        <div class="form-group col-md-4">
            <label for="phone1">Teléfono 1</label>
            <input type="number" class="form-control" id="phone1" name="phone1" placeholder="Teléfono 1" required>
        </div>
        <div class="form-group col-md-4">
            <label for="phone2">Teléfono 2</label>
            <input type="number" class="form-control" id="phone2" name="phone2" placeholder="Teléfono 2">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-3">
            <label for="address">Dirección</label>
            <input type="text" class="form-control" id="address" name="address" placeholder="Dirección" required>
        </div>
        <div class="form-group col-md-3">
            <label for="location">Población</label>
            <input type="text" class="form-control" id="location" name="location" placeholder="Población" required>
        </div>
        <div class="form-group col-md-3">
            <label for="province">Provincia</label>
            <input type="text" class="form-control" id="province" name="province" placeholder="Provincia" required>
        </div>
        <div class="form-group col-md-3">
            <label for="country">País</label>
            <input type="text" class="form-control" id="country" name="country" placeholder="País" required>
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

            if(!validateDocument($('#document').val())) { // Validamos documento
                formValid = false;
                resetFields();
                showAlert("El número de documento no contiene un formato válido.", "danger", "modalAlert");
            } else if($('#password1').val() !== $('#password2').val()) { // Validamos contraseñas
                formValid = false;
                resetFields();
                showAlert("Las contraseñas introducidas no coinciden. Por favor, vuelva a intentarlo.", "danger", "modalAlert");
            } else if($('#password1').val().length < 4) {
                formValid = false;
                resetFields();
                showAlert("La longitud de la contraseña debe ser igual o superior a 4 dígitos.", "danger", "modalAlert");
            }

            if(formValid) {
                $.ajax({
                    type: "POST",
                    url: "php/pages/register/crud.register.php",
                    data: $("#form").serialize(),
                    success: function(data) {
                        if(data === 'OK') {
                            $.ajax({
                                type: "POST",
                                url: "php/security/authentication.php",
                                data: { email: $('#email').val(), password: $('#password1').val() },
                                success: function(data) {
                                    if(data === 'OK') {
                                        window.history.back();
                                    } else {
                                        showAlert("No se han encontrado coincidencias el usuario y contraseña introducidos.", "danger");
                                    }
                                },
                                error: function(XMLHttpRequest, textStatus, errorThrown) {
                                    showAlert("Ha ocurrido un error inesperado.", "danger");
                                }
                            });
                        } else {
                            resetFields();
                            $('#modaladdEdit').modal('toggle');
                            showAlert(data, "danger");
                        }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        resetFields();
                        $('#modaladdEdit').modal('toggle');
                        showAlert("Ha ocurrido un error inesperado.", "danger");
                    }
                });
            }
        });
    });

    function resetFields() {
        $('#document').val('');
        $('#password1').val('');
        $('#password2').val('');
        $('#modalAlert').html('');
    }
</script>