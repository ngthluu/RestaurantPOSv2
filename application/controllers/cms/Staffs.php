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

	public function add() {
		if (isset($_GET["type"]) && $_GET["type"] == "chef") {
			$data["type"] = "chef";
			$data["header_title"] = "Chefs management";
			$data["breadcrumb_list"] = array(
				array("uri" => site_url("cms/dashboard"), "title" => "Home"),
				array("uri" => site_url("cms/staffs?type=chef"), "title" => "Chefs"),
				array("uri" => "#", "title" => "Add Chef"),
			);
		} else if (isset($_GET["type"]) && $_GET["type"] == "waiter") {
			$data["type"] = "waiter";
			$data["header_title"] = "Waiters management";
			$data["breadcrumb_list"] = array(
				array("uri" => site_url("cms/dashboard"), "title" => "Home"),
				array("uri" => site_url("cms/staffs?type=waiter"), "title" => "Waiters"),
				array("uri" => "#", "title" => "Add Waiter"),
			);
		} else {
			$data["type"] = "manager";
			$data["header_title"] = "Managers management";
			$data["breadcrumb_list"] = array(
				array("uri" => site_url("cms/dashboard"), "title" => "Home"),
				array("uri" => site_url("cms/staffs?type=manager"), "title" => "Managers"),
				array("uri" => "#", "title" => "Add Manager"),
			);
		}

		$this->load->model("M_Branch");
		$data["branch_list"] = $this->M_Branch->gets_all(array("status" => M_Branch::STATUS_ACTIVE));
		
        $data["main_view"] = "cms/staffs/add";
		$this->load->view("cms/layout/main", $data);
	}
	
}
