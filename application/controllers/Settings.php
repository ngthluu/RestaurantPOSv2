<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends SITE_Controllers {

	public function __construct() {
		parent::__construct();

		if (!is_logged_in()) {
			redirect(site_url());
		}

		$this->load->model("M_Customer");
	}

	public function index() {
        $data["main_header"] = "Settings";
        $data["main_view"] = "homepage/settings";
		$this->load->view("homepage/layout/main", $data);
	}
}
