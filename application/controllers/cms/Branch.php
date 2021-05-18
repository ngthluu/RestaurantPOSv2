<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Branch extends CMS_Controllers {

	public function __construct() {
		parent::__construct();

		$this->load->model("M_Branch");
	}

	public function index()
	{
		$data["header_title"] = "Branch";
		$data["breadcrumb_list"] = array(
			array("uri" => site_url("cms/dashboard"), "title" => "Home"),
			array("uri" => "#", "title" => "Branch"),
		);
        $data["main_view"] = "cms/branch/home";

		$data["branch_list"] = $this->M_Branch->gets_all();

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

		$this->load->model("M_Manager");
		$data["managers_list"] = $this->M_Manager->gets_all();

		$this->load->view("cms/layout/main", $data);
	}
}
