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

	public function signout() {
		unset($_SESSION["uid"]);
        redirect(site_url());
	}

	public function test_notification() {
		$this->load->helper("onesignal_helper");
		$this->load->model("M_Customer");
		$uid = $this->M_Customer->get_notification_uid($_SESSION["uid"]);
		$result = sendMessage($uid, [
			"status" => "ok",
			"message" => "Hello World"
		]);
		var_dump($result);
	}
}
