<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends SITE_Controllers {

	public function __construct() {
		parent::__construct();

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
}
