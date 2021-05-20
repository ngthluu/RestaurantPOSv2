<?php 
if (isset($_SESSION["alert_message"])) {
    $message = $_SESSION["alert_message"];
    unset($_SESSION["alert_message"]);
?>
<div class="modal fade" id="modal-message">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Alert</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <p><?= $message ?></p>
        </div>
        <div class="modal-footer justify-content-end">
            <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
        </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<script>
document.addEventListener("DOMContentLoaded", function (event) {
    $("#modal-message").modal('show');
});

</script>
<?php } ?>