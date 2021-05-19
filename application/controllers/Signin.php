<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signin extends SITE_Controllers {

	public function index() {
        $data["main_header"] = "Sign in";
        $data["main_view"] = "homepage/signin";
		$this->load->view("homepage/layout/main", $data);
	}
}
