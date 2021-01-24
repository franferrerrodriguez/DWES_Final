<?php $id = "addEdit"; ?>

<?php include('php/pages/common/open-modal-large.php'); ?>

<form id="form<?php echo $id; ?>">
    <input type="hidden" id="id" value="">
    <div class="form-group">
        <label for="exampleInputEmail1">Reply to:</label>
        <input type="email" class="form-control" id="email" readonly>
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Mensaje (*):</label>
        <textarea class="form-control" id="message" rows="4" placeholder="Mensaje" required></textarea>
    </div>

    <div id="modalAlert"></div>

    <button type="submit" class="btn btn-primary">Enviar</button>
    <button type="reset" class="btn btn-secondary">Borrar</button>
</form>

<hr/>

<div id="tickets"></div>

<?php include('php/pages/common/close-modal-large.php'); ?>