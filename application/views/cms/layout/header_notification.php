<?php 
$CI = &get_instance();
$CI->load->model("M_Order");
$where = [
    "order_time >= " => beginDate(),
    "order_time <= " => endDate()
];
if (!in_role(["admin"])) {
    $where = array_merge($where, ["branch" => $_SESSION["cms_ubranch"]]);
}
if (!in_role(["admin", "manager"])) {
    $where = array_merge($where, ["status <> " => M_Order::STATUS_INIT]);
}
$total_count = $CI->M_Order->gets_count(array_merge($where, ["status != " => M_Order::STATUS_PAYMENT_FAILED]));
$initialized_count = $CI->M_Order->gets_count(array_merge($where, ["status" => M_Order::STATUS_INIT]));
$paid_count = $CI->M_Order->gets_count(array_merge($where, ["status" => M_Order::STATUS_PAYMENT_OK]));
$received_count = $CI->M_Order->gets_count(array_merge($where, ["status" => M_Order::STATUS_RECEIVED]));
$processing_count = $CI->M_Order->gets_count(array_merge($where, ["status" => M_Order::STATUS_IN_PROCESS]));
$finish_count = $CI->M_Order->gets_count(array_merge($where, ["status" => M_Order::STATUS_FINISHED]));
?>

<a class="nav-link" data-toggle="dropdown" href="#">
    <i class="far fa-bell"></i>
    <span class="badge badge-warning navbar-badge"><?= $total_count ?></span>
</a>
<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
    <span class="dropdown-item dropdown-header"><?= $total_count ?> orders</span>
    <div class="dropdown-divider"></div>
    <?php if (in_role(["admin", "manager"])) { ?>
    <a href="#" class="dropdown-item">
        <i class="fas fa-file-alt mr-2"></i> <?= $initialized_count ?> initialized orders
        <span class="float-right text-muted text-sm">0 mins</span>
    </a>
    <?php } ?>
    <div class="dropdown-divider"></div>
    <a href="#" class="dropdown-item">
        <i class="fas fa-file-alt mr-2"></i> <?= $paid_count ?> ready orders
        <span class="float-right text-muted text-sm">0 mins</span>
    </a>
    <div class="dropdown-divider"></div>
    <a href="#" class="dropdown-item">
        <i class="fas fa-file-alt mr-2"></i> <?= $received_count ?> received orders
        <span class="float-right text-muted text-sm">0 mins</span>
    </a>
    <div class="dropdown-divider"></div>
    <a href="#" class="dropdown-item">
        <i class="fas fa-file-alt mr-2"></i> <?= $processing_count ?> in-processing orders
        <span class="float-right text-muted text-sm">0 mins</span>
    </a>
    <div class="dropdown-divider"></div>
    <a href="#" class="dropdown-item">
        <i class="fas fa-file-alt mr-2"></i> <?= $finish_count ?> finished orders
        <span class="float-right text-muted text-sm">0 mins</span>
    </a>
</div>