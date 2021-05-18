<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Staffs extends CMS_Controllers {

	public function index()
	{
		$data["header_title"] = "Staffs";
		$data["breadcrumb_list"] = array(
			array("uri" => site_url("cms/dashboard"), "title" => "Home"),
			array("uri" => "#", "title" => "Staffs"),
		);
        $data["main_view"] = "cms/staffs/home";
		$this->load->view("cms/layout/main", $data);
	}

	public function not_found() {
		
	}
}
