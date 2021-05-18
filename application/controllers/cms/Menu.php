<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CMS_Controllers {

	public function index()
	{
		$data["header_title"] = "Menu";
		$data["breadcrumb_list"] = array(
			array("uri" => site_url("cms/dashboard"), "title" => "Home"),
			array("uri" => "#", "title" => "Menu"),
		);
        $data["main_view"] = "cms/menu/home";
		$this->load->view("cms/layout/main", $data);
	}

	public function not_found() {
		
	}
}