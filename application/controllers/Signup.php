<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signup extends SITE_Controllers {

	public function __construct() {
		parent::__construct();

		if (is_logged_in()) {
			redirect(site_url());
		}

		$this->load->model("M_Customer");
	}

	public function index() {
        $data["main_header"] = "Sign up";
        $data["main_view"] = "homepage/signup";
		$this->load->view("homepage/layout/main", $data);
	}

	public function check_form() {
		$phone = $this->input->post("phone");
		$password = $this->input->post("password");
		$repassword = $this->input->post("repassword");
		$privacy = $this->input->post("privacy");

		if (!preg_match('/^[0-9]{10}$/', $phone)) {
            raise_message_err("Please type the correct phone number");
			echo $this->load->view("homepage/layout/message_box", null, true);
			return false;
        }

		if (strlen($password) < 6) {
			raise_message_err("Your password length must be greater than 5");
			echo $this->load->view("homepage/layout/message_box", null, true);
			return false;
		}

		if ($password != $repassword) {
			raise_message_err("Your re typed password is not match");
			echo $this->load->view("homepage/layout/message_box", null, true);
			return false;
		}

		if (!isset($privacy)) {
			raise_message_err("Please accept the Privacy and Policy");
			echo $this->load->view("homepage/layout/message_box", null, true);
			return false;
		}

		$existed_account = $this->M_Customer->is_existed($phone);
		if ($existed_account) {
			raise_message_err("This phone has existed in the system");
			echo $this->load->view("homepage/layout/message_box", null, true);
			return false;
		}
		
		echo "ok";
		return true;
	}

	public function save() {
		$is_correct_form = $this->check_form();
		if ($is_correct_form) {
			$this->M_Customer->add();
			raise_message_ok("Created successfully. Sign in to try the features");
			redirect(site_url("signup"));
		} else {
			raise_message_err("Your form is not valid");
			redirect(site_url("signup"));
		}
		redirect(site_url("signup"));
	}
}
