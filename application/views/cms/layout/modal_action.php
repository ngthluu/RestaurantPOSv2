<div class="modal fade" id="modal-alert">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="modal-alert-title"></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <p id="modal-alert-message"></p>
        </div>
        <div class="modal-footer justify-content-end">
            <a href="#" class="btn btn-primary" id="modal-alert-submit">OK</a>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script>
document.addEventListener("DOMContentLoaded", function (event) {

$(".btn-modal").click(function(e) {
    e.preventDefault();
    let title = $(this).attr("data-title");
    let message = $(this).attr("data-message");
    let submit = $(this).attr("data-submit");
    $("#modal-alert-title").html(title);
    $("#modal-alert-message").html(message);
    $("#modal-alert-submit").attr("href", submit);

});


});

</script>