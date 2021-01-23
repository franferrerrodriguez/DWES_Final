<?php $id = "addEdit"; ?>

<?php include('php/pages/common/open-modal-large.php'); ?>

<form id="form<?php echo $id; ?>">
    <input type="hidden" id="id" value="">
    <div class="form-group">
        <label for="exampleInputEmail1">Asunto (*):</label>
        <input type="text" id="issue" class="form-control" placeholder="Asunto" required>
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Email (*):</label>
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

<div class="alert alert-success" role="alert" style="float:right;width:80%;text-align:right;">
     [11:32:11] - This is a success alert—check it out!
</div>

<div class="alert alert-dark" role="alert" style="float:left;width:80%;">
    [20:20:12] - This is a dark alert—check it out!
</div>

<?php include('php/pages/common/close-modal-large.php'); ?>