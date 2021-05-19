<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customers extends CMS_Controllers {

	public function __construct() {
		parent::__construct();

		if (!in_role(["admin"])) {
			redirect(site_url("cms/dashboard"));
			return;
		}  

		$this->load->model("M_Customers");
	}

	public function index() {

		if (isset($_GET["locked"]) && $_GET["locked"] == "true") {
			$locked_status = M_Customers::STATUS_LOCKED;
			$data["header_title"] = "Customers management";
			$data["breadcrumb_list"] = [
				["uri" => site_url("cms/dashboard"), "title" => "Home"],
				["uri" => "#", "title" => "Customers (Locked)"],
			];
		} else {
			$locked_status = M_Customers::STATUS_PUBLISHED;
			$data["header_title"] = "Customers management";
			$data["breadcrumb_list"] = [
				["uri" => site_url("cms/dashboard"), "title" => "Home"],
				["uri" => "#", "title" => "Customers"],
			];
		}
		$data["main_view"] = "cms/customers/home";
		$data["customers_list"] = $this->M_Customers->gets_all(["status" => $locked_status]);

		$this->load->view("cms/layout/main", $data);
	}

	public function change_status($id=null) {
		if ($id) {
			$this->M_Customers->change_status($id);
			alert_message_box("Updated successfully");
		}
		redirect(site_url("cms/customers"));
	}

	public function delete($id=null) {
		if ($id) {
			$this->M_Customers->delete($id);
			alert_message_box("Deleted successfully");
		}
		redirect(site_url("cms/customers"));
	}
	
}
