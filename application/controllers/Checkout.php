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

		// Generate payment url
		$order = $this->M_Order->get($order_id);
		$order_price = $this->M_Order->get_price($order_id);
		$this->load->helper("momo_helper");
		$data["payment_url"] = paymentMomo($order, $order_price);

		$this->load->view("homepage/layout/main", $data);
	}

	public function payment_result() {

		$this->load->model("M_Order");

		$this->load->helper("momo_helper");
		$check_payment_result = paymentMomoCheckResult($_GET);

		$order_code = explode(".", $_GET["orderId"]);
		$order_code = $order_code[0];
		$order = $this->M_Order->get_with_code($order_code);

		if ($check_payment_result == "ok") {
			$data["main_header"] = "Payment successfully";
        	$data["main_view"] = "homepage/checkout-success";

			// Paid successfully
			$this->M_Order->paid($order->id);

		} else if ($check_payment_result == "failed"){
			$data["main_header"] = "Payment failed";
			$data["message"] = "Your transaction is broken, please try again.";
        	$data["main_view"] = "homepage/checkout-failed";
		} else {
			$data["main_header"] = "Payment failed";
			$data["message"] = $check_payment_result;
        	$data["main_view"] = "homepage/checkout-failed";
			
			// Paid failed
			$this->M_Order->cancel($order->id);
		}

		$this->load->view("homepage/layout/main", $data);
	}

	public function payment_notify() {
		$this->load->model("M_Order");

		$this->load->helper("momo_helper");
		$check_payment_result = paymentMomoCheckResult($_POST);

		$order_code = explode(".", $_POST["orderId"]);
		$order_code = $order_code[0];
		$order = $this->M_Order->get_with_code($order_code);

		if ($check_payment_result == "ok") {
			$data["main_header"] = "Payment successfully";
        	$data["main_view"] = "homepage/checkout-success";

			// Paid successfully
			$this->M_Order->paid($order->id);

		} else if ($check_payment_result == "failed"){
			$data["main_header"] = "Payment failed";
			$data["message"] = "Your transaction is broken, please try again.";
        	$data["main_view"] = "homepage/checkout-failed";
		} else {
			$data["main_header"] = "Payment failed";
			$data["message"] = $check_payment_result;
        	$data["main_view"] = "homepage/checkout-failed";
			
			// Paid failed
			$this->M_Order->cancel($order->id);
		}

		$this->load->view("homepage/layout/main", $data);
	}

}
