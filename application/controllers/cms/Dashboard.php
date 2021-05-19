<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CMS_Controllers {

	public function index()
	{
		$data["header_title"] = "Dashboard";
		$data["breadcrumb_list"] = [
			["uri" => site_url("cms/dashboard"), "title" => "Home"],
			["uri" => "#", "title" => "Dashboard"],
		];
        $data["main_view"] = "cms/dashboard/home";
		$this->load->view("cms/layout/main", $data);
	}

	public function not_found() {
		
	}
}
