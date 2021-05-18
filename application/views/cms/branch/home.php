<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="card">
    <div class="card-header">
        <div class="card-title">
            <a class="btn btn-primary btn-sm" href="<?= site_url("cms/branch/add")?>">
                <i class="fas fa-plus"></i> Add Branch
            </a>
        </div>

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
                    <th> # </th>
                    <th> Name </th>
                    <th> Address </th>
                    <th> Number of tables </th>
                    <th> Manager </th>
                    <th class="text-center"> Status </th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php 
            if (empty($branch_list)) echo '<tr><td colspan="7">Branches list is empty</td></tr>'; 
            else foreach ($branch_list as $branch) { 
            ?>
                <tr>
                    <td> # </td>
                    <td> <?= $branch->name ?></td>
                    <td> <?= $branch->address ?></td>
                    <td> <?= $branch->tables_num ?> </td>
                    <td>
                    <?php 
                    $manager = $this->M_Manager->get($branch->manager);
                    echo $manager ? $manager->email." - ".$manager->name : "";
                    ?>
                    </td>
                    <td class="project-state">
                    <?php 
                    if ($branch->status == 0) {
                        echo '<span class="badge badge-warning">Paused</span>';
                    } else if ($branch->status == 1) {
                        echo '<span class="badge badge-success">Active</span>';
                    }
                    ?>
                    </td>
                    <td class="project-actions text-right">
                        <a class="btn btn-info btn-sm" href="<?= site_url("cms/branch/edit/".$branch->id) ?>">
                            <i class="fas fa-pencil-alt"> </i> Edit
                        </a>
                        <?php if ($branch->status == 0) { ?>
                        <a class="btn btn-primary btn-sm btn-modal" href="#" 
                            data-toggle="modal" 
                            data-target="#modal-alert"
                            data-title="Active branch"
                            data-message="Are you sure to active this branch ?"
                            data-submit="<?= site_url("cms/branch/change_status/".$branch->id) ?>"
                        >
                            <i class="fas fa-unlock"> </i> Active
                        </a>
                        <?php } else if ($branch->status == 1) { ?>
                        <a class="btn btn-primary btn-sm btn-modal" href="#"
                            data-toggle="modal" 
                            data-target="#modal-alert"
                            data-title="Pause branch"
                            data-message="Are you sure to pause this branch ?"
                            data-submit="<?= site_url("cms/branch/change_status/".$branch->id) ?>"
                        >
                            <i class="fas fa-lock"> </i> Pause
                        </a>
                        <?php } ?>
                        <a class="btn btn-primary btn-sm" href="<?= site_url("cms/branch/qrcode/".$branch->id) ?>">
                            <i class="fas fa-qrcode"> </i> QR Code
                        </a>
                        <a class="btn btn-danger btn-sm btn-modal" href="#"
                            data-toggle="modal" 
                            data-target="#modal-alert"
                            data-title="Delete branch"
                            data-message="Are you sure to delete this branch ?"
                            data-submit="<?= site_url("cms/branch/delete/".$branch->id) ?>"
                        >
                            <i class="fas fa-trash"> </i> Delete
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