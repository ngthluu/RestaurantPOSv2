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
		$this->load->model("M_Manager");

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

	public function edit($id) {
		$data["header_title"] = "Branch";
		$data["breadcrumb_list"] = array(
			array("uri" => site_url("cms/dashboard"), "title" => "Home"),
			array("uri" => site_url("cms/branch"), "title" => "Branch"),
			array("uri" => "#", "title" => "Edit Branch"),
		);
        $data["main_view"] = "cms/branch/add";

		$this->load->model("M_Manager");
		$data["managers_list"] = $this->M_Manager->gets_all();

		$data["branch"] = $this->M_Branch->get($id);

		$this->load->view("cms/layout/main", $data);
	}

	public function save($id=null) {
		$is_correct_form = $this->check_form();
		if ($is_correct_form) {
			if ($id) {
				$this->M_Branch->update($id);
				$_SESSION["cms_message_ok"] = "Updated successfully";
				redirect(site_url("cms/branch/edit/".$id));
			} else {
				$this->M_Branch->add();
				$_SESSION["cms_message_ok"] = "Added successfully";
				redirect(site_url("cms/branch/add"));
			}
		} else {
			$_SESSION["cms_message_err"] = "Your form is not valid";
			redirect(site_url("cms/branch/add"));
		}
	}

	public function check_form() {

		$name = $this->input->post("name");
		$address = $this->input->post("address");
		$numberOfTables = $this->input->post("tablesNum");
		$manager = $this->input->post("manager");

		if (strlen(trim($name)) == 0) {
			$_SESSION["cms_message_err"] = "Please type the branch name";
			echo $this->load->view("cms/layout/message_box", null, true);
			return false;
		}

		if (strlen(trim($address)) == 0) {
			$_SESSION["cms_message_err"] = "Please type the branch address";
			echo $this->load->view("cms/layout/message_box", null, true);
			return false;
		}

		if (!(filter_var($numberOfTables, FILTER_VALIDATE_INT) && $numberOfTables > 0)) {
			$_SESSION["cms_message_err"] = "Please type a correct number of tables";
			echo $this->load->view("cms/layout/message_box", null, true);
			return false;
		}
		
		echo "ok";
		return true;
	}

	public function change_status($id) {

	}
}
