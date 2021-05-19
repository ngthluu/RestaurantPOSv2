<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signup extends SITE_Controllers {

	public function __construct() {
		parent::__construct();
	}

	public function index() {
        $data["main_header"] = "Sign up";
        $data["main_view"] = "homepage/signup";
		$this->load->view("homepage/layout/main", $data);
	}

	public function check_form() {

	}

	public function save() {
		redirect(site_url("signin"));
	}
}
