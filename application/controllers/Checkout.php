<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checkout extends SITE_Controllers {

	public function __construct() {
		parent::__construct();

		if (!is_logged_in()) {
			redirect(site_url());
		}
	}

	public function index() {
        $data["main_header"] = "Order checkout";
        $data["main_view"] = "homepage/checkout";

		$this->load->model("M_Menu");

		$this->load->view("homepage/layout/main", $data);
	}

	public function waiting() {

		if (!isset($_SESSION["cart"])) {
			redirect(site_url("checkout"));
			return;
		}

		if (isset($_POST["note"])) {
			$_SESSION["cart"]->note = $this->input->post("note");
		}

		$data["main_header"] = "Order successfully";
        $data["main_view"] = "homepage/checkout-waiting";

		$this->load->model("M_Order");
		$order_id = $this->M_Order->save();
		unset($_SESSION["cart"]);

		// Notify to branch manager
		$order = $this->M_Order->get($order_id);
		$this->load->model("M_Staff");
		$uids = $this->M_Staff->get_notification_uids(["role" => "manager", "branch" => $order->branch]);
		$this->load->helper("onesignal_helper");
		sendMessage($uids, [
			"status" => "ok",
			"message" => "Order $order->order_code has been placed."
		]);

		// Generate payment url
		$order = $this->M_Order->get($order_id);
		$order_price = $this->M_Order->get_price($order_id);
		$this->load->helper("momo_helper");
		$data["payment_url"] = paymentMomo($order, $order_price);

		$this->load->view("homepage/layout/main", $data);
	}

	private function pay_success($order_code) {
		$this->load->model("M_Order");
		
		$order = $this->M_Order->get_with_code($order_code);
		$this->M_Order->paid($order->id);

		// Pay successful, notify to all branch chefs
		$this->load->model("M_Staff");
		$uids = $this->M_Staff->get_notification_uids(["role" => "chef", "branch" => $order->branch]);
		$this->load->helper("onesignal_helper");
		sendMessage($uids, [
			"status" => "ok",
			"message" => "Order $order->order_code has been paid. Please receive this order as soon as possible."
		]);
	}

	private function pay_failed ($order_code) {
		$this->load->model("M_Order");
		
		$order = $this->M_Order->get_with_code($order_code);
	}

	public function payment_result() {

		$this->load->helper("momo_helper");
		$check_payment_result = paymentMomoCheckResult($_GET);

		$order_code = explode(".", $_GET["orderId"]);
		$order_code = $order_code[0];

		if ($check_payment_result == "ok") {
			$data["main_header"] = "Payment successfully";
        	$data["main_view"] = "homepage/checkout-success";

			// Paid successfully
			$this->pay_success($order_code);

		} else if ($check_payment_result == "failed"){
			$data["main_header"] = "Payment failed";
			$data["message"] = "Your transaction is broken, please try again.";
        	$data["main_view"] = "homepage/checkout-failed";
		} else {
			$data["main_header"] = "Payment failed";
			$data["message"] = $check_payment_result;
        	$data["main_view"] = "homepage/checkout-failed";
			
			// Paid successfully
			$this->pay_failed($order_code);
		}

		$this->load->view("homepage/layout/main", $data);
	}

	public function payment_notify() {
		$this->load->helper("momo_helper");
		$check_payment_result = paymentMomoCheckResult($_POST);

		$order_code = explode(".", $_POST["orderId"]);
		$order_code = $order_code[0];

		if ($check_payment_result == "ok") {
			$data["main_header"] = "Payment successfully";
        	$data["main_view"] = "homepage/checkout-success";

			// Paid successfully
			$this->pay_success($order_code);

		} else if ($check_payment_result == "failed"){
			$data["main_header"] = "Payment failed";
			$data["message"] = "Your transaction is broken, please try again.";
        	$data["main_view"] = "homepage/checkout-failed";
		} else {
			$data["main_header"] = "Payment failed";
			$data["message"] = $check_payment_result;
        	$data["main_view"] = "homepage/checkout-failed";
			
			// Paid successfully
			$this->pay_failed($order_code);
		}

		$this->load->view("homepage/layout/main", $data);
	}

}
