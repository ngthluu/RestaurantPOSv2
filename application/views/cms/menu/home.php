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
                    <td> <img width="50px" src="<?= $menu->image ? base_url("resources/menu/".$menu->id."/".$menu->image) : base_url("resources/no-image.jpg"); ?>" alt=""> </td>
                    <td> <?= $menu->name ?></td>
                    <td> <?= number_format($menu->price) ?></td>
                    <td> 
                    <?php 
                        $branch = $this->M_Branch->get($menu->branch);
                        echo $branch ? $branch->name : "";
                        ?>    
                    </td>
                    <td> 
                    <?php 
                    if ($menu->status == M_Menu::STATUS_NOT_PUBLISHED) {
                        echo '<span class="badge badge-warning">Not Published</span>';
                    } else if ($menu->status == M_Menu::STATUS_PUBLISHED) {
                        echo '<span class="badge badge-success">Published</span>';
                    }
                    ?>
                    </td>
                    <td class="project-state">
                    <?php 
                    if ($menu->status_date == M_Menu::STATUS_DATE_NOT_AVAILABLE) {
                        echo '<span class="badge badge-warning">Not Available</span>';
                    } else if ($menu->status_date == M_Menu::STATUS_DATE_AVAILABLE) {
                        echo '<span class="badge badge-success">Available</span>';
                    }
                    ?>
                    </td>
                    <td class="project-actions text-right">
                        <a class="btn btn-info btn-sm" href="<?= site_url("cms/menu/edit/".$menu->id) ?>">
                            <i class="fas fa-pencil-alt"> </i> Edit
                        </a>
                        <?php if ($menu->status == M_Menu::STATUS_DATE_NOT_AVAILABLE) { ?>
                        <a class="btn btn-primary btn-sm btn-modal" href="#" 
                            data-toggle="modal" 
                            data-target="#modal-alert"
                            data-title="Publish Menu"
                            data-message="Are you sure you want to publish this menu ?"
                            data-submit="<?= site_url("cms/menu/change-status/".$menu->id) ?>"
                        >
                            <i class="fas fa-unlock"> </i> Publish
                        </a>
                        <?php } else if ($menu->status == M_Menu::STATUS_DATE_AVAILABLE) { ?>
                        <a class="btn btn-primary btn-sm btn-modal" href="#"
                            data-toggle="modal" 
                            data-target="#modal-alert"
                            data-title="Un-publish Menu"
                            data-message="Are you sure you want to un-publish this menu ?"
                            data-submit="<?= site_url("cms/menu/change-status/".$menu->id) ?>"
                        >
                            <i class="fas fa-lock"> </i> Un-publish
                        </a>
                        <?php } ?>
                        <?php if ($menu->status == M_Menu::STATUS_DATE_NOT_AVAILABLE) { ?>
                        <a class="btn btn-primary btn-sm btn-modal" href="#" 
                            data-toggle="modal" 
                            data-target="#modal-alert"
                            data-title="Make menu available today"
                            data-message="Are you sure you want to make this menu available today ?"
                            data-submit="<?= site_url("cms/menu/change-status-date/".$menu->id) ?>"
                        >
                            <i class="fas fa-unlock"> </i> Avaiable
                        </a>
                        <?php } else if ($menu->status == M_Menu::STATUS_DATE_AVAILABLE) { ?>
                        <a class="btn btn-primary btn-sm btn-modal" href="#"
                            data-toggle="modal" 
                            data-target="#modal-alert"
                            data-title="Make menu not available today"
                            data-message="Are you sure you want to make this menu not available today ?"
                            data-submit="<?= site_url("cms/menu/change-status-date/".$menu->id) ?>"
                        >
                            <i class="fas fa-lock"> </i> Not Available
                        </a>
                        <?php } ?>
                        <a class="btn btn-danger btn-sm btn-modal" href="#"
                            data-toggle="modal" 
                            data-target="#modal-alert"
                            data-title="Delete menu"
                            data-message="Are you sure you want to delete this menu ?"
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