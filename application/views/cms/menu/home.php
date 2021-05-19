<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="card">
    <div class="card-header">
        <div class="card-title">
            <a class="btn btn-primary btn-sm" href="<?= site_url("cms/menu/add")?>">
                <i class="fas fa-plus"></i> Add Menu
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
    <div class="card-body p-0 table-responsive">
        <table class="table table-striped projects">
            <thead>
                <tr>
                    <th> # </th>
                    <th> Image </th>
                    <th> Name </th>
                    <th> Price </th>
                    <th> Branch </th>
                    <th class="text-center"> Status </th>
                    <th class="text-center"> Status (day) </th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php 
            if (empty($menu_list)) echo '<tr><td colspan="8">Menu list is empty</td></tr>'; 
            else foreach ($menu_list as $menu) { 
            ?>
                <tr>
                    <td> # </td>
                    <td> <?= $menu->email ?> </td>
                    <td> <?= $menu->name ?></td>
                    <td> <?= $menu->phone ?></td>
                    <td> <?= gender_array()[$menu->gender] ?> </td>
                    <td> 
                    <?php 
                    $branch = $this->M_Branch->get($menu->branch);
                    echo $branch ? $branch->name : "";
                    ?>
                     </td>
                    <td class="project-state">
                    <?php 
                    if ($menu->status == M_Staff::STATUS_LOCKED) {
                        echo '<span class="badge badge-warning">Locked</span>';
                    } else if ($menu->status == M_Staff::STATUS_PUBLISHED) {
                        echo '<span class="badge badge-success">Active</span>';
                    }
                    ?>
                    </td>
                    <td class="project-actions text-right">
                        <a class="btn btn-info btn-sm" href="<?= site_url("cms/menu/edit/".$menu->id) ?>">
                            <i class="fas fa-pencil-alt"> </i> Edit
                        </a>
                        <?php if ($menu->status == M_Staff::STATUS_LOCKED) { ?>
                        <a class="btn btn-primary btn-sm btn-modal" href="#" 
                            data-toggle="modal" 
                            data-target="#modal-alert"
                            data-title="Active account"
                            data-message="Are you sure you want to active this account ?"
                            data-submit="<?= site_url("cms/menu/change-status/".$menu->id) ?>"
                        >
                            <i class="fas fa-unlock"> </i> Active
                        </a>
                        <?php } else if ($menu->status == M_Staff::STATUS_PUBLISHED) { ?>
                        <a class="btn btn-primary btn-sm btn-modal" href="#"
                            data-toggle="modal" 
                            data-target="#modal-alert"
                            data-title="Lock account"
                            data-message="Are you sure you want to lock this account ?"
                            data-submit="<?= site_url("cms/menu/change-status/".$menu->id) ?>"
                        >
                            <i class="fas fa-lock"> </i> Lock
                        </a>
                        <?php } ?>
                        <a class="btn btn-primary btn-sm btn-modal" href="#"
                            data-toggle="modal"
                            data-target="#modal-alert"
                            data-title="Reset password"
                            data-message="Are you sure you want to reset this account password to 123456 ?"
                            data-submit="<?= site_url("cms/menu/reset-password/".$menu->id) ?>"
                        >
                            <i class="fas fa-key"> </i> Reset password
                        </a>
                        <a class="btn btn-danger btn-sm btn-modal" href="#"
                            data-toggle="modal" 
                            data-target="#modal-alert"
                            data-title="Delete staff"
                            data-message="Are you sure you want to delete this staff ?"
                            data-submit="<?= site_url("cms/menu/delete/".$menu->id) ?>"
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