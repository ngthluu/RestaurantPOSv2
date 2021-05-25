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
    <div class="card-body p-0 table-responsive">
        <table class="table table-striped projects">
            <thead>
                <tr>
                    <th> # </th>
                    <th> Image </th>
                    <th> Name </th>
                    <th> Phone </th>
                    <th> Birthday </th>
                    <th> Gender </th>
                    <th> Address </th>
                    <th class="text-center"> Status </th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php 
            if (empty($customers_list)) echo '<tr><td colspan="9">Customers is empty</td></tr>'; 
            else foreach ($customers_list as $customer) { 
            ?>
                <tr>
                    <td> # </td>
                    <td> <img width="50px" src="<?= $customer->avatar ? base_url("resources/customers/".$customer->id."/".$customer->avatar) : base_url("resources/no-avatar.png"); ?>" alt=""> </td>
                    <td> <?= $customer->name ?></td>
                    <td> <?= $customer->phone ?></td>
                    <td> <?= date("d/m/Y", strtotime($customer->birthday)) ?></td>
                    <td> <?= gender_array()[$customer->gender] ?></td>
                    <td> <?= $customer->address ?></td>
                    <td class="project-state"> 
                    <?php 
                    if ($customer->status == M_Customer::STATUS_LOCKED) {
                        echo '<span class="badge badge-warning">Locked</span>';
                    } else if ($customer->status == M_Customer::STATUS_PUBLISHED) {
                        echo '<span class="badge badge-success">Actived</span>';
                    }
                    ?>
                    </td>
                    <td class="project-actions text-right">
                        <?php if ($customer->status == M_Customer::STATUS_LOCKED) { ?>
                        <a class="btn btn-primary btn-sm btn-modal" href="#" 
                            data-toggle="modal" 
                            data-target="#modal-alert"
                            data-title="Un-lock customer"
                            data-message="Are you sure you want to un-lock this customer ?"
                            data-submit="<?= site_url("cms/customers/change-status/".$customer->id) ?>"
                        >
                            <i class="fas fa-unlock"> </i> Un-lock
                        </a>
                        <?php } else if ($customer->status == M_Customer::STATUS_PUBLISHED) { ?>
                        <a class="btn btn-primary btn-sm btn-modal" href="#"
                            data-toggle="modal" 
                            data-target="#modal-alert"
                            data-title="Lock customer"
                            data-message="Are you sure you want to lock this customer ?"
                            data-submit="<?= site_url("cms/customers/change-status/".$customer->id) ?>"
                        >
                            <i class="fas fa-lock"> </i> Lock
                        </a>
                        <?php } ?>
                        <a class="btn btn-primary btn-sm btn-modal" href="#"
                            data-toggle="modal"
                            data-target="#modal-alert"
                            data-title="Reset password"
                            data-message="Are you sure you want to reset this customer password to 123456 ?"
                            data-submit="<?= site_url("cms/customers/reset-password/".$customer->id) ?>"
                        >
                            <i class="fas fa-key"> </i> Reset password
                        </a>
                        <a class="btn btn-danger btn-sm btn-modal" href="#"
                            data-toggle="modal" 
                            data-target="#modal-alert"
                            data-title="Delete customer"
                            data-message="Are you sure you want to delete this customer ?"
                            data-submit="<?= site_url("cms/customers/delete/".$customer->id) ?>"
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
    <div class="card-footer clearfix">
        <?= $this->pagination->create_links(); ?>
    </div>
    </div>
    <!-- /.card -->

</section>
<!-- /.content -->


<?php $this->load->view("cms/layout/modal_action") ?>
<?php $this->load->view("cms/layout/alert_box") ?>