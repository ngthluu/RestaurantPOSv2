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
                    <th> Code </th>
                    <th> Customer </th>
                    <th> Branch </th>
                    <th> Table </th>
                    <th> Details </th>
                    <th> Total price </th>
                    <th class="text-center"> Status </th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            <?php 
            if (empty($orders_list)) echo '<tr><td colspan="9">Orders list is empty</td></tr>'; 
            else foreach ($orders_list as $order) { 
            ?>
                <tr>
                    <td> # </td>
                    <td> <?= $order->order_code ?> </td>
                    <td> <?= $order->customer ?></td>
                    <td> <?= $order->branch ?></td>
                    <td> <?= $order->table ?></td>
                    <td>  </td>
                    <td>  </td>
                    <td> 
                    <?php 
                    if ($order->status == M_Order::STATUS_INIT) {
                        echo '<span class="badge badge-primary">Initialized</span>';
                    } else if ($order->status == M_Order::STATUS_PAYMENT_OK) {
                        echo '<span class="badge badge-info">Payment OK</span>';
                    } else if ($order->status == M_Order::STATUS_PAYMENT_FAILED) {
                        echo '<span class="badge badge-danger">Payment Failed</span>';
                    } else if ($order->status == M_Order::STATUS_RECEIVED) {
                        echo '<span class="badge badge-info">Received</span>';
                    } else if ($order->status == M_Order::STATUS_IN_PROCESS) {
                        echo '<span class="badge badge-warning">In Processing</span>';
                    } else if ($order->status == M_Order::STATUS_FINISHED) {
                        echo '<span class="badge badge-success">Finished</span>';
                    }
                    ?>
                    </td>
                    <td class="project-actions text-right">
                        <?php if ($order->status == M_Order::STATUS_PAYMENT_OK) { ?>
                        <a class="btn btn-primary btn-sm btn-modal" href="#" 
                            data-toggle="modal" 
                            data-target="#modal-alert"
                            data-title="Receive order"
                            data-message="Are you sure you want to receive this order ?"
                            data-submit="<?= site_url("cms/orders/change-status/".$order->id) ?>"
                        >
                            <i class="fas fa-inbox"> </i> Receive
                        </a>
                        <?php } else if ($order->status == M_Order::STATUS_RECEIVED) { ?>
                        <a class="btn btn-primary btn-sm btn-modal" href="#"
                            data-toggle="modal" 
                            data-target="#modal-alert"
                            data-title="Process order"
                            data-message="Are you sure you want to process this order ?"
                            data-submit="<?= site_url("cms/orders/change-status/".$order->id) ?>"
                        >
                            <i class="fas fa-shipping-fast"> </i> In-Process
                        </a>
                        <?php } else if ($order->status == M_Order::STATUS_IN_PROCESS) { ?>
                        <a class="btn btn-primary btn-sm btn-modal" href="#"
                            data-toggle="modal" 
                            data-target="#modal-alert"
                            data-title="Finish order"
                            data-message="Are you sure you want to finish this order ?"
                            data-submit="<?= site_url("cms/orders/change-status/".$order->id) ?>"
                        >
                            <i class="fas fa-thumbs-up"> </i> Finish
                        </a>
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