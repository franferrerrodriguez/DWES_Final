<?php 

// El $id es requerido si deseamos controlar el modal desde jQuery
if(!isset($id)) {
    $id = uniqid(); 
}

?>

<div class="modal fade bd-modal-lg<?php echo $id; ?>" id="modal<?php echo $id; ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel<?php echo $id; ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalTitle<?php echo $id; ?>"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" id="modalContent<?php echo $id; ?>">