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
			$data["orders_list"] = $this->M_Order->gets_all();
		} else if (in_role(["manager"])){
			$data["orders_list"] = $this->M_Order->gets_all([
				"branch" => $_SESSION["cms_ubranch"]
			]);
		} else {
			$data["orders_list"] = $this->M_Order->gets_all([
				"branch" => $_SESSION["cms_ubranch"],
				"status != " => M_Order::STATUS_INIT,
				"status <> " => M_Order::STATUS_PAYMENT_FAILED,
				"order_time >= " => beginDate(),
    			"order_time <= " => endDate()
			]);
		}
		
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
