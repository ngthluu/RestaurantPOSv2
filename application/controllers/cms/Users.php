<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CMS_Controllers {

	public function index()
	{
		$data["header_title"] = "Users";
		$data["breadcrumb_list"] = array(
			array("uri" => site_url("cms/dashboard"), "title" => "Home"),
			array("uri" => "#", "title" => "Users"),
		);
        $data["main_view"] = "cms/users/home";
		$this->load->view("cms/layout/main", $data);
	}

	public function not_found() {
		
	}
}
