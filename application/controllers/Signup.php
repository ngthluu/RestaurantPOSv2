<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signup extends SITE_Controllers {

	public function index() {
        $data["main_header"] = "Sign up";
        $data["main_view"] = "homepage/signup";
		$this->load->view("homepage/layout/main", $data);
	}
}
