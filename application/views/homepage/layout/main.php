<?php 
$this->load->view("homepage/layout/header", ["data" => isset($data) ? $data : null]);
if (isset($main_view)) {
    $this->load->view($main_view, ["data" => isset($data) ? $data : null]);
}
$this->load->view("homepage/layout/footer", ["data" => isset($data) ? $data : null]);