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
                    <th> Avatar </th>
                    <th> Email </th>
                    <th> Name </th>
                    <th> Branch </th>
                    <th> Role </th>
                    <th class="text-center"> Salary </th>
                    <th class="text-center"> Payment status</th>
                    <th class="text-center"> Payment time</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php 
            if (empty($staffs_list)) echo '<tr><td colspan="8">Staffs list is empty</td></tr>'; 
            else foreach ($staffs_list as $staff) { 
                $this_month_payment = $this->M_Staff->get_this_month_payment($staff->id);
            ?>
                <tr>
                    <td> # </td>
                    <td> <img width="50px" src="<?= $staff->avatar ? base_url("resources/users/".$staff->id."/".$staff->avatar) : base_url("resources/no-avatar.png"); ?>" alt=""> </td>
                    <td> <a href="<?= site_url("cms/staffs/edit/".$staff->id."?type=".$staff->role) ?>"><?= $staff->email ?></a> </td>
                    <td> <?= $staff->name ?></td>
                    <td> 
                    <?php 
                    $branch = $this->M_Branch->get($staff->branch);
                    if ($branch) echo '<a href="'.site_url("cms/branch/edit/".$branch->id).'">'.$branch->name.'</a>';
                    ?>
                     </td>
                    <td class="text-capitalize"> <?= $staff->role ?></td>
                    <td class="project-state"> <?= number_format($staff->salary) ?> </td>
                    
                    <td class="project-state">
                    <?php 
                    if (!$this_month_payment) {
                        echo '<span class="badge badge-danger">Not Paid</span>';
                    } else {
                        echo '<span class="badge badge-success">Paid</span>';
                    }
                    ?>
                    </td>
                    <td class="project-state">
                        <?= $this_month_payment ? date("H:i:s d/m/Y", strtotime($this_month_payment->payment_date)) : "" ?>
                    </td>
                    <td class="project-actions text-right">
                        <?php if (in_role(["admin", "manager"])) { ?>
                        <?php if (!$this_month_payment) { ?>
                        <a class="btn btn-primary btn-sm btn-modal" href="#" 
                            data-toggle="modal" 
                            data-target="#modal-alert"
                            data-title="Pay salary for this staff"
                            data-message="Are you sure you want to pay salary for this staff ?"
                            data-submit="<?= site_url("cms/staffs/pay-salary/".$staff->id) ?>"
                        >
                            <i class="fas fa-dollar-sign"> </i> Pay
                        </a>
                        <?php } ?>
                        <?php } ?>
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