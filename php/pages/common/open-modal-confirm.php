<?php 

// El $id es requerido si deseamos controlar el modal desde jQuery

if(!isset($id)) {
    $id = uniqid(); 
}

?>

<div class="modal fade" id="<?php echo $id; ?>" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel<?php echo $id; ?>" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle<?php echo $id; ?>">Título</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalContent<?php echo $id; ?>">