<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends CMS_Controllers {

	public function index()
	{
		$data["header_title"] = "Orders";
		$data["breadcrumb_list"] = array(
			array("uri" => site_url("cms/dashboard"), "title" => "Home"),
			array("uri" => "#", "title" => "Orders"),
		);
        $data["main_view"] = "cms/orders/home";
		$this->load->view("cms/layout/main", $data);
	}

	public function not_found() {
		
	}
}
