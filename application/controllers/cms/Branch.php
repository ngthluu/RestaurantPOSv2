<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Branch extends CMS_Controllers {

	public function __construct() {
		parent::__construct();

		if (!in_role(["admin", "manager"])) {
			redirect(site_url("cms/dashboard"));
			return;
		} 
		$this->load->model("M_Branch");
	}

	public function index() {
		$data["header_title"] = "Branch management";
		$data["breadcrumb_list"] = [
			["uri" => site_url("cms/dashboard"), "title" => "Home"],
			["uri" => "#", "title" => "Branch"],
		];
        $data["main_view"] = "cms/branch/home";
		
		if (!in_role(["admin"])) {
			$data["branch_list"] = $this->M_Branch->gets_all(["id" => $_SESSION["cms_ubranch"]]);
		} else {
			$data["branch_list"] = $this->M_Branch->gets_all();
		}
		
		$this->load->model("M_Staff");

		$this->load->view("cms/layout/main", $data);
	}

	public function qrcode($id) {
		$data["header_title"] = "Branch management";
		$data["breadcrumb_list"] = [
			["uri" => site_url("cms/dashboard"), "title" => "Home"],
			["uri" => site_url("cms/branch"), "title" => "Branch"],
			["uri" => "#", "title" => "QR Code"],
		];
        $data["main_view"] = "cms/branch/qrcode";
		
		$data["branch"] = $this->M_Branch->get($id);

		$this->load->view("cms/layout/main", $data);
	}

	public function add() {
		$data["header_title"] = "Branch management";
		$data["breadcrumb_list"] = [
			["uri" => site_url("cms/dashboard"), "title" => "Home"],
			["uri" => site_url("cms/branch"), "title" => "Branch"],
			["uri" => "#", "title" => "Add Branch"],
		];
        $data["main_view"] = "cms/branch/add";

		$this->load->model("M_Staff");
		$data["managers_list"] = $this->M_Staff->set_role("manager")->gets_all(["status" => M_Staff::STATUS_PUBLISHED]);

		$this->load->view("cms/layout/main", $data);
	}

	public function edit($id=null) {
		if (!$id) {
			redirect(site_url("cms/branch"));
			return;
		}

		$data["header_title"] = "Branch management";
		$data["breadcrumb_list"] = [
			["uri" => site_url("cms/dashboard"), "title" => "Home"],
			["uri" => site_url("cms/branch"), "title" => "Branch"],
			["uri" => "#", "title" => "Edit Branch"],
		];
        $data["main_view"] = "cms/branch/add";

		$this->load->model("M_Staff");
		$data["managers_list"] = $this->M_Staff->set_role("manager")->gets_all(["status" => M_Staff::STATUS_PUBLISHED]);

		$data["branch"] = $this->M_Branch->get($id);

		$this->load->view("cms/layout/main", $data);
	}

	public function save($id=null) {
		$is_correct_form = $this->check_form();
		if ($is_correct_form) {
			if ($id) {
				$this->M_Branch->update($id);
				raise_message_ok("Updated successfully");
				redirect(site_url("cms/branch/edit/".$id));
			} else {
				$this->M_Branch->add();
				raise_message_ok("Added successfully");
				redirect(site_url("cms/branch/add"));
			}
		} else {
			raise_message_err("Your form is not valid");
			redirect(site_url("cms/branch/add"));
		}
	}

	public function check_form() {

		$name = $this->input->post("name");
		$address = $this->input->post("address");
		$numberOfTables = $this->input->post("tablesNum");
		$manager = $this->input->post("manager");

		if (strlen(trim($name)) == 0) {
			raise_message_err("Please type the branch name");
			echo $this->load->view("cms/layout/message_box", null, true);
			return false;
		}

		if (strlen(trim($address)) == 0) {
			raise_message_err("Please type the branch address");
			echo $this->load->view("cms/layout/message_box", null, true);
			return false;
		}

		if (!(filter_var($numberOfTables, FILTER_VALIDATE_INT) && $numberOfTables > 0)) {
			raise_message_err("Please type a correct number of tables");
			echo $this->load->view("cms/layout/message_box", null, true);
			return false;
		}
		
		echo "ok";
		return true;
	}

	public function change_status($id=null) {
		if ($id) {
			$this->M_Branch->change_status($id);
			alert_message_box("Updated successfully");
		}
		redirect(site_url("cms/branch"));
	}

	public function delete($id=null) {
		if ($id) {
			$this->M_Branch->delete($id);
			alert_message_box("Deleted successfully");
		}
		redirect(site_url("cms/branch"));
	}
}
