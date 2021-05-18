<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Branch extends CMS_Controllers {

	public function __construct() {
		parent::__construct();
	}

	public function index()
	{
		$data["header_title"] = "Branch";
		$data["breadcrumb_list"] = array(
			array("uri" => site_url("cms/dashboard"), "title" => "Home"),
			array("uri" => "#", "title" => "Branch"),
		);
        $data["main_view"] = "cms/branch/home";
		$this->load->view("cms/layout/main", $data);
	}

	public function add() {
		$data["header_title"] = "Branch";
		$data["breadcrumb_list"] = array(
			array("uri" => site_url("cms/dashboard"), "title" => "Home"),
			array("uri" => site_url("cms/branch"), "title" => "Branch"),
			array("uri" => "#", "title" => "Add Branch"),
		);
        $data["main_view"] = "cms/branch/add";
		$this->load->view("cms/layout/main", $data);
	}
}
