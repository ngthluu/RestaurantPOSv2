<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customers extends CMS_Controllers {

	public function __construct() {
		parent::__construct();

		if (!in_role(["admin"])) {
			redirect(site_url("cms/dashboard"));
			return;
		}  

		$this->load->model("M_Customer");
	}

	public function index() {

		if (isset($_GET["locked"]) && $_GET["locked"] == "true") {
			$locked_status = M_Customer::STATUS_LOCKED;
			$data["header_title"] = "Customers management";
			$data["breadcrumb_list"] = [
				["uri" => site_url("cms/dashboard"), "title" => "Home"],
				["uri" => "#", "title" => "Customers (Locked)"],
			];
		} else {
			$locked_status = M_Customer::STATUS_PUBLISHED;
			$data["header_title"] = "Customers management";
			$data["breadcrumb_list"] = [
				["uri" => site_url("cms/dashboard"), "title" => "Home"],
				["uri" => "#", "title" => "Customers"],
			];
		}
		$data["main_view"] = "cms/customers/home";
		
		$where = ["status" => $locked_status];

		$per_page = 10;
		if (isset($_GET["page"]) && filter_var($_GET["page"], FILTER_VALIDATE_INT) && $_GET["page"] > 0) {
			$page = $_GET["page"];
		} else {
			$page = 1;
		}
		$data["customers_list"] = $this->M_Customer->gets_all($where, $page, $per_page);
		$total_items = $this->M_Customer->gets_count($where);
		$this->load->library('pagination');
		$this->pagination->initialize(paginationConfigs(
			$page, $per_page, $total_items,
			"cms/customers"
		));

		$this->load->view("cms/layout/main", $data);
	}

	public function change_status($id=null) {
		if ($id) {
			$this->M_Customer->change_status($id);
			alert_message_box("Updated successfully");
		}
		redirect(site_url("cms/customers"));
	}

	public function delete($id=null) {
		if ($id) {
			$this->M_Customer->delete($id);
			alert_message_box("Deleted successfully");
		}
		redirect(site_url("cms/customers"));
	}
	
}
