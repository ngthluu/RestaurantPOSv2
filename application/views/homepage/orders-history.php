<main id="main" class="d-flex flex-column justify-content-center menu-list">
    <div class="container">
        <h1 class="page-title t-white font-weight-bold mt-3">
            Your orders history
        </h1>
        <?php if (!empty($orders_list)) { ?>
        <div class="row gy-4">
        <?php 
        foreach ($orders_list as $order) { 
            $order_details = $this->M_Order->get_details($order->id);
        ?>
            <div class="col-md-6 mb-3">
                <div class="checkoutinfo-box d-flex flex-column justify-content-between">
                    <div class="d-flex justify-content-between">
                        <strong class="t-red">#<?= $order->order_code?></strong>
                        <strong>
                        <?php 
                        if ($order->status == M_Order::STATUS_INIT) {
                            echo '<strong class="text-primary">Initialized</strong>';
                        } else if ($order->status == M_Order::STATUS_PAYMENT_OK) {
                            echo '<strong class="text-info">Payment OK</strong>';
                        } else if ($order->status == M_Order::STATUS_PAYMENT_FAILED) {
                            echo '<strong class="text-danger">Payment Failed</strong>';
                        } else if ($order->status == M_Order::STATUS_RECEIVED) {
                            echo '<strong class="text-info">Received</strong>';
                        } else if ($order->status == M_Order::STATUS_IN_PROCESS) {
                            echo '<strong class="text-warning">In Processing</strong>';
                        } else if ($order->status == M_Order::STATUS_FINISHED) {
                            echo '<strong class="text-success">Finished</strong>';
                        }
                        ?>
                        </strong>
                    </div>
                    <div class="d-flex flex-column justify-content-between">
                    <?php foreach ($order_details as $detail) { ?>
                        <div class="mt-2 d-flex justify-content-between align-items-center">
                            <div class="d-flex justify-content-start align-items-center">
                                <img class="rounded-circle" width="75px" height="75px" src="<?= $detail->image ? base_url("resources/menu/".$detail->id."/".$detail->image) : base_url("resources/no-image.jpg") ?>" alt="">
                                <div class="d-flex flex-column justify-content-start ml-2">
                                    <strong><?= $detail->name ?> x <?= $detail->quantity ?></strong>
                                    <strong class="t-red"><?= number_format($detail->price) ?>đ</strong>
                                </div>
                            </div>
                            <strong class="t-red"><?= number_format($detail->quantity * $detail->price) ?>đ</strong>
                        </div>
                    <?php } ?>
                    </div>
                    <div class="mt-2 d-flex justify-content-between">
                        <div class="t-red"> <?= date("H:i:s d/m/Y", strtotime($order->order_time)) ?> </div>
                        <strong class="t-red">Total: <?= number_format($this->M_Order->get_price($order->id)) ?>đ</strong>
                    </div>
                    <?php if ($order->status == M_Order::STATUS_INIT) { ?>
                    <div class="mt-2 d-flex justify-content-end">
                        <a target="_blank" href="<?= site_url("order/pay/".$order->id) ?>" class="btn btn-danger mr-2">Pay</a>
                        <a href="<?= site_url("order/cancel/".$order->id) ?>" class="btn btn-secondary">Cancel</a>
                    </div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
        </div>
        <?php } else { ?>
        <div class="t-yellow mt-3">Your orders history is currently empty.</div> 
        <?php } ?>
    </div>
</main>

