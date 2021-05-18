<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customers extends CMS_Controllers {

	public function index()
	{
		$data["header_title"] = "Customers";
		$data["breadcrumb_list"] = array(
			array("uri" => site_url("cms/dashboard"), "title" => "Home"),
			array("uri" => "#", "title" => "Customers"),
		);
        $data["main_view"] = "cms/customers/home";
		$this->load->view("cms/layout/main", $data);
	}

	public function not_found() {
		
	}
}
