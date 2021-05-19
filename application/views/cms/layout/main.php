<?php 
$this->load->view("cms/layout/header", ["data" => isset($data) ? $data : null]);
if (isset($main_view)) {
    $this->load->view($main_view, ["data" => isset($data) ? $data : null]);
}
$this->load->view("cms/layout/footer", ["data" => isset($data) ? $data : null]);