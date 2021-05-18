<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="card">
    <div class="card-header">

        <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
            <i class="fas fa-minus"></i>
        </button>
        <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
            <i class="fas fa-times"></i>
        </button>
        </div>
    </div>
    <div class="card-body p-0">
        <table class="table table-striped projects">
            <thead>
                <tr>
                    <th> Table Number </th>
                    <th> Link </th>
                    <th> QR Code </th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php 
            for ($table = 1; $table <= $branch->tables_num; $table++) { 
                $url = site_url("order?branch=".$branch->id."&table=".$table);
            ?>
                <tr>
                    <td> <?= "#".$table ?> </td>
                    <td> <a href="<?= $url ?>"><?= $url ?></a></td>
                    <td> <img src="https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=<?= $url ?>" alt=""> </td>
                    <td class="project-actions text-right">
                        <a class="btn btn-primary btn-sm" href="#">
                            <i class="fas fa-print"> </i> Print
                        </a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    <!-- /.card-body -->
    </div>
    <!-- /.card -->

</section>
<!-- /.content -->

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

<?php $this->load->view("cms/layout/alert_box") ?>

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