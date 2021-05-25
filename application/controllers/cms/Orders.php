<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends CMS_Controllers {

	public function __construct() {
		parent::__construct();

		$this->load->model("M_Order");
	}

	public function index() {

		$data["header_title"] = "Orders management";
		$data["breadcrumb_list"] = [
			["uri" => site_url("cms/dashboard"), "title" => "Home"],
			["uri" => "#", "title" => "Orders"],
		];

		$data["main_view"] = "cms/orders/home";

		if (in_role(["admin"])) {
			$where = [];
		} else if (in_role(["manager"])){
			$where = ["branch" => $_SESSION["cms_ubranch"]];
		} else {
			$where = [
				"branch" => $_SESSION["cms_ubranch"],
				"status != " => M_Order::STATUS_INIT,
				"status <> " => M_Order::STATUS_PAYMENT_FAILED,
				"order_time >= " => beginDate(),
    			"order_time <= " => endDate()
			];
		}
		
		$per_page = 10;
		if (isset($_GET["page"]) && filter_var($_GET["page"], FILTER_VALIDATE_INT) && $_GET["page"] > 0) {
			$page = $_GET["page"];
		} else {
			$page = 1;
		}
		$data["orders_list"] = $this->M_Order->gets_all($where, $page, $per_page);
		$total_items = $this->M_Order->gets_count($where);

		$this->load->library('pagination');
		$this->pagination->initialize(paginationConfigs(
			$page, $per_page, $total_items,
			"cms/orders"
		));
		
		$this->load->model("M_Branch");
		$this->load->model("M_Customer");

		$this->load->view("cms/layout/main", $data);
	}

	public function change_status($id=null) {
		if ($id) {
			$this->M_Order->change_status($id);
			alert_message_box("Updated successfully");
		}
		redirect(site_url("cms/orders"));
	}
	
}
