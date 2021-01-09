<script type="text/javascript">
    $(document).ready(function(){
        $('#email').focus();
    });
</script>

<center><h2>Iniciar sesión</h2></center>

<form id="form" method="POST">
    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Introduce tu email" value="root@root.com">
    </div>
    <div class="form-group">
        <label for="password">Contraseña:</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Introduce tu contraseña" value="R1234t">
    </div>
    <br>
    <input class="btn btn-primary" type="submit" value="Acceder">
    <input class="btn btn-secondary" type="reset" value="Borrar">
</form>

<br>
<a class="btn btn-success" href="?page=register" role="button">Registrarse</a>
<script>
    $("form").submit(function(event) {
        $.ajax({
            type: "POST",
            url: "php/security/authentication.php",
            data: $("#form").serialize(),
            success: function(data) {
                data = JSON.parse(data);
                if(!data.responseError) {
                    window.location.href = '?index';
                } else {
                    showAlert("No se han encontrado coincidencias el usuario y contraseña introducidos.", "danger");
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                showAlert("Ha ocurrido un error inesperado.", "danger");
            }
        });

        event.preventDefault();
    });
</script>