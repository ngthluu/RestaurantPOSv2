<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends SITE_Controllers {

	public function index() {
        $data["main_view"] = "homepage/home";
		$this->load->view("homepage/layout/main", $data);
	}

	public function not_found() {
		$data["main_view"] = "homepage/not-found";
		$this->load->view("homepage/layout/main", $data);
	}
}
