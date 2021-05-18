<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Staffs extends CMS_Controllers {

	public function index() {
		if (isset($_GET["type"]) && $_GET["type"] == "chef") {
			$data["type"] = "chef";
			$data["header_title"] = "Chefs management";
			$data["breadcrumb_list"] = array(
				array("uri" => site_url("cms/dashboard"), "title" => "Home"),
				array("uri" => "#", "title" => "Chefs"),
			);
		} else if (isset($_GET["type"]) && $_GET["type"] == "waiter") {
			$data["type"] = "waiter";
			$data["header_title"] = "Waiters management";
			$data["breadcrumb_list"] = array(
				array("uri" => site_url("cms/dashboard"), "title" => "Home"),
				array("uri" => "#", "title" => "Waiters"),
			);
		} else {
			$data["type"] = "manager";
			$data["header_title"] = "Managers management";
			$data["breadcrumb_list"] = array(
				array("uri" => site_url("cms/dashboard"), "title" => "Home"),
				array("uri" => "#", "title" => "Managers"),
			);
		}

		$data["main_view"] = "cms/staffs/home";
		$this->load->view("cms/layout/main", $data);
	}

	
}
