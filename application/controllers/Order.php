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

		$this->load->view("homepage/layout/main", $data);
	}
}
