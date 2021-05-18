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
                    <td> <?= $branch->manager ?></td>
                    <td class="project-state">
                        <span class="badge badge-success">Success</span>
                    </td>
                    <td class="project-actions text-right">
                        <a class="btn btn-info btn-sm" href="#">
                            <i class="fas fa-pencil-alt"> </i> Edit
                        </a>
                        <a class="btn btn-primary btn-sm" href="#">
                            <i class="fas fa-lock"> </i> Pause
                        </a>
                        <a class="btn btn-primary btn-sm" href="#">
                            <i class="fas fa-qrcode"> </i> QR Code
                        </a>
                        <a class="btn btn-danger btn-sm" href="#">
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