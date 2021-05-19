<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends SITE_Controllers {

	public function index() {
        $data["main_view"] = "homepage/home";
		$this->load->view("homepage/layout/main", $data);
	}

	public function privacy_policy() {
		$data["main_header"] = "Privacy policy";
		$data["main_view"] = "homepage/privacy-policy";
		$this->load->view("homepage/layout/main", $data);
	}

	public function contact_us() {
		$data["main_header"] = "Contact us";
		$data["main_view"] = "homepage/contact-us";
		$this->load->view("homepage/layout/main", $data);
	}

	public function not_found() {
		$data["main_header"] = "404 not found";
		$data["main_view"] = "homepage/not-found";
		$this->load->view("homepage/layout/main", $data);
	}
}
