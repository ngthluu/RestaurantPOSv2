<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Statistics extends CMS_Controllers {

	public function __construct() {
		parent::__construct();
	}

	public function revenue() {

		$data["header_title"] = "Revenue";
		$data["breadcrumb_list"] = array(
			array("uri" => site_url("cms/dashboard"), "title" => "Home"),
			array("uri" => "#", "title" => "Revenue"),
		);

		$data["main_view"] = "cms/statistics/revenue";

		$this->load->view("cms/layout/main", $data);
	}

	public function salary() {

		$data["header_title"] = "Staffs salary";
		$data["breadcrumb_list"] = array(
			array("uri" => site_url("cms/dashboard"), "title" => "Home"),
			array("uri" => "#", "title" => "Salary"),
		);

        $this->load->model("M_Staff");
        $this->load->model("M_Branch");
        $data["staffs_list"] = $this->M_Staff->gets_all();

		$data["main_view"] = "cms/statistics/salary";

		$this->load->view("cms/layout/main", $data);
	}
	
}
