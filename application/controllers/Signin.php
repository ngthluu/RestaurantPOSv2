<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signin extends SITE_Controllers {

	public function __construct() {
		parent::__construct();

		if (is_logged_in()) {
			redirect(site_url());
		}

		$this->load->model("M_Customer");
	}

	public function index() {
        $data["main_header"] = "Sign in";
        $data["main_view"] = "homepage/signin";
		$this->load->view("homepage/layout/main", $data);
	}

	public function signin() {

		$phone = $this->input->post("phone");
        $password = $this->input->post("password");

		if ($this->M_Customer->signin($phone, $password)) {
			redirect(site_url());
		} else {
			raise_message_err("Your phone/password is not correct");
			redirect(site_url("signin"));
		}
	}
}
