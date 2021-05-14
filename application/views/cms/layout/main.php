<?php 
$this->load->view("cms/layout/header", array("data" => isset($data) ? $data : null));
if (isset($main_view)) {
    $this->load->view($main_view, array("data" => isset($data) ? $data : null));
}
$this->load->view("cms/layout/footer", array("data" => isset($data) ? $data : null));