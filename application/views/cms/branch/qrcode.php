<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="card">
    <div class="card-header">

        <div class="card-title">
            <a class="btn btn-primary btn-sm" href="#">
                <i class="fas fa-print"></i> Print all
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

<?php $this->load->view("cms/layout/modal_action") ?>
<?php $this->load->view("cms/layout/alert_box") ?>