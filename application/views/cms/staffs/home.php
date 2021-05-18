<?php 
if ($type == "chef") {
    $type_text = "Chef";
} else if ($type == "waiter") {
    $type_text = "Waiter";
} else {
    $type_text = "Manager";
}
?>

<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="card">
    <div class="card-header">
        <div class="card-title">
            <a class="btn btn-primary btn-sm" href="<?= site_url("cms/staffs/add?type=".$type)?>">
                <i class="fas fa-plus"></i> Add <?= $type_text ?>
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
                    <th> Email </th>
                    <th> Name </th>
                    <th> Phone </th>
                    <th> Gender </th>
                    <th> Branch </th>
                    <th class="text-center"> Status </th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php 
            if (empty($staffs_list)) echo '<tr><td colspan="8">'.$type_text.' list is empty</td></tr>'; 
            else foreach ($staffs_list as $staff) { 
            ?>
                <tr>
                    <td> # </td>
                    <td> <?= $staff->email ?> </td>
                    <td> <?= $staff->name ?></td>
                    <td> <?= $staff->phone ?></td>
                    <td> <?= gender_array()[$staff->gender] ?> </td>
                    <td> 
                    <?php 
                    $branch = $this->M_Branch->get($staff->branch);
                    echo $branch ? $branch->name : "";
                    ?>
                     </td>
                    <td class="project-state">
                    <?php 
                    if ($staff->status == M_Staff::STATUS_LOCKED) {
                        echo '<span class="badge badge-warning">Locked</span>';
                    } else if ($staff->status == M_Staff::STATUS_PUBLISHED) {
                        echo '<span class="badge badge-success">Active</span>';
                    }
                    ?>
                    </td>
                    <td class="project-actions text-right">
                        <a class="btn btn-info btn-sm" href="<?= site_url("cms/staffs/edit/".$staff->id."?type=".$type) ?>">
                            <i class="fas fa-pencil-alt"> </i> Edit
                        </a>
                        <?php if ($staff->status == M_Staff::STATUS_LOCKED) { ?>
                        <a class="btn btn-primary btn-sm btn-modal" href="#" 
                            data-toggle="modal" 
                            data-target="#modal-alert"
                            data-title="Active account"
                            data-message="Are you sure you want to active this account ?"
                            data-submit="<?= site_url("cms/staffs/change-status/".$staff->id."?type=".$type) ?>"
                        >
                            <i class="fas fa-unlock"> </i> Active
                        </a>
                        <?php } else if ($staff->status == M_Staff::STATUS_PUBLISHED) { ?>
                        <a class="btn btn-primary btn-sm btn-modal" href="#"
                            data-toggle="modal" 
                            data-target="#modal-alert"
                            data-title="Lock account"
                            data-message="Are you sure you want to lock this account ?"
                            data-submit="<?= site_url("cms/staffs/change-status/".$staff->id."?type=".$type) ?>"
                        >
                            <i class="fas fa-lock"> </i> Lock
                        </a>
                        <?php } ?>
                        <a class="btn btn-primary btn-sm btn-modal" href="#"
                            data-toggle="modal"
                            data-target="#modal-alert"
                            data-title="Reset password"
                            data-message="Are you sure you want to reset this account password to 123456 ?"
                            data-submit="<?= site_url("cms/staffs/reset-password/".$staff->id."?type=".$type) ?>"
                        >
                            <i class="fas fa-key"> </i> Reset password
                        </a>
                        <a class="btn btn-danger btn-sm btn-modal" href="#"
                            data-toggle="modal" 
                            data-target="#modal-alert"
                            data-title="Delete staff"
                            data-message="Are you sure you want to delete this staff ?"
                            data-submit="<?= site_url("cms/staffs/delete/".$staff->id."?type=".$type) ?>"
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


<?php $this->load->view("cms/layout/modal_action") ?>
<?php $this->load->view("cms/layout/alert_box") ?>