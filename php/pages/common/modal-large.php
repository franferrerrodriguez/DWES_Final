<?php $id = uniqid(); ?>

<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg<?php echo $id; ?>">
    <i class="fas fa-<?php echo $button_icon; ?>"></i>
    <?php echo $button_title; ?>
</button>

<div class="modal fade bd-example-modal-lg<?php echo $id; ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel<?php echo $id; ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel<?php echo $id; ?>"><?php echo $modal_title; ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">