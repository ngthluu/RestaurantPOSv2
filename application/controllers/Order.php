<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends SITE_Controllers {

	public function __construct() {
		parent::__construct();

        // Log customer table
        if ($this->uri->segment(2) === 'index') {
            $branch_id = $this->uri->segment(3);
            $table_num = $this->uri->segment(4);
            if ($branch_id
                && $table_num
                && filter_var($branch_id, FILTER_VALIDATE_INT)
                && filter_var($table_num, FILTER_VALIDATE_INT)
            ) {
                $_SESSION["ubranch"] = $branch_id;
                $_SESSION["utable"] = $table_num;
            }
        }

		if (!is_logged_in()) {
			redirect(site_url());
		}

        $this->load->model("M_Menu");
	}

	public function index($branch_id=null, $table_num=null) {

        if (!(
            $branch_id
            && $table_num
            && filter_var($branch_id, FILTER_VALIDATE_INT)
            && filter_var($table_num, FILTER_VALIDATE_INT)
        )) {
            redirect(site_url("404_error"));
            return;
        }
        
        $data["main_header"] = "Our menu";
        $data["main_view"] = "homepage/order";

        $data["menu_list"] = $this->M_Menu->gets_all([
            "branch" => $branch_id,
            "status" => M_Menu::STATUS_PUBLISHED,
            "status_date" => M_Menu::STATUS_DATE_AVAILABLE
        ]);
        $data["branch_id"] = $branch_id;
        $data["table_num"] = $table_num;

		$this->load->view("homepage/layout/main", $data);
	}

    public function history() {
        $data["main_header"] = "Orders history";
        $data["main_view"] = "homepage/orders-history";

        $this->load->model("M_Order");
        $data["orders_list"] = $this->M_Order->gets_all([
            "customer" => $_SESSION["uid"]
        ]);

		$this->load->view("homepage/layout/main", $data);
    }

    public function add_cart($branch_id=null, $table_num=null) {
        if (!(
            $branch_id
            && $table_num
            && filter_var($branch_id, FILTER_VALIDATE_INT)
            && filter_var($table_num, FILTER_VALIDATE_INT)
        )) {
            echo "Invalid request";
            return;
        }

        $menuId = $this->input->post("menuId");
        $menuQuantity = $this->input->post("menuQuantity");
        if (!(
            $menuId
            && $menuQuantity
            && filter_var($menuId, FILTER_VALIDATE_INT)
            && filter_var($menuQuantity, FILTER_VALIDATE_INT)
            && $menuQuantity > 0
        )) {
            echo "Your menu or quantity is not valid";
            return;
        }

        if (!isset($_SESSION["cart"])) {
            $_SESSION["cart"] = (object) [
                "branch" => -1,
                "table" => -1,
                "note" => "",
                "details" => []
            ];
        }
        $_SESSION["cart"]->branch = $branch_id;
        $_SESSION["cart"]->table = $table_num;
        foreach ($_SESSION["cart"]->details as $index => $detail) {
            if ($menuId == $detail->id) {
                $_SESSION["cart"]->details[$index]->quantity += $menuQuantity;
                echo "ok";
                return;
            }
        }
        $_SESSION["cart"]->details[] = (object) [
            "id" => $menuId,
            "quantity" => $menuQuantity
        ];

        echo "ok";
    }

    public function update_cart() {

        $menuId = $this->input->post("menuId");
        $menuQuantity = $this->input->post("menuQuantity");
        if (!(
            $menuId
            && $menuQuantity
            && filter_var($menuId, FILTER_VALIDATE_INT)
            && filter_var($menuQuantity, FILTER_VALIDATE_INT)
            && $menuQuantity > 0
        )) {
            echo json_encode([
                "status" => "error",
                "message" => "Your menu or quantity is not valid"
            ]);
            return;
        }

        if (!isset($_SESSION["cart"])) {
            echo json_encode([
                "status" => "error",
                "message" => "Your cart is not valid"
            ]);
            return;
        }
        foreach ($_SESSION["cart"]->details as $index => $detail) {
            if ($menuId == $detail->id) {
                $menuQuantityOld = $_SESSION["cart"]->details[$index]->quantity;
                $_SESSION["cart"]->details[$index]->quantity = $menuQuantity;
                $menu = $this->M_Menu->get($menuId);
                echo json_encode([
                    "status" => "ok",
                    "menuPrice" => $menu->price,
                    "menuQuantityNew" => $menuQuantity,
                    "menuQuantityOld" => $menuQuantityOld
                ]);
                return;
            }
        }
        echo json_encode([
            "status" => "error",
            "message" => "Your cart is not valid"
        ]);
        return;
    }

    public function remove_cart() {

        $menuId = $this->input->post("menuId");
        if (!(
            $menuId
            && filter_var($menuId, FILTER_VALIDATE_INT)
        )) {
            echo "Your menu is not valid";
            return;
        }

        foreach ($_SESSION["cart"]->details as $index => $detail) {
            if ($menuId == $detail->id) {
                unset($_SESSION["cart"]->details[$index]);
                echo "ok";
                return;
            }
        }
        echo "Your menu is not valid";
        return;
    }

    public function cancel($id) {
        $this->load->model("M_Order");
        $this->M_Order->cancel($id);
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function pay($id) {
        // Generate payment url
        $this->load->model("M_Order");
		$order = $this->M_Order->get($id);
		$order_price = $this->M_Order->get_price($id);
		$this->load->helper("momo_helper");
		$payment_url = paymentMomo($order, $order_price);
        redirect($payment_url);
    }
}
