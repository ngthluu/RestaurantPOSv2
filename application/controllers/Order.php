<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends SITE_Controllers {

	public function __construct() {
		parent::__construct();

		if (!is_logged_in()) {
			redirect(site_url());
		}
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

		$this->load->view("homepage/layout/main", $data);
	}
}
