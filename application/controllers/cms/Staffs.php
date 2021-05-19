<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Staffs extends CMS_Controllers {

	public function __construct() {
		parent::__construct();

		if (!in_role(["admin", "manager"])) {
			redirect(site_url("cms/dashboard"));
			return;
		} 

		$this->load->model("M_Staff");
	}

	public function index() {

		if (isset($_GET["type"]) && $_GET["type"] == "chef") {
			$type = "chef";
		} else if (isset($_GET["type"]) && $_GET["type"] == "waiter") {
			$type = "waiter";
		} else {
			$type = "manager";
			if (!in_role(["admin"])) {
				redirect(site_url("cms/staffs?type=chef"));
				return;
			}
		}

		if ($type == "chef") {
			$data["header_title"] = "Chefs management";
			$data["breadcrumb_list"] = [
				["uri" => site_url("cms/dashboard"), "title" => "Home"],
				["uri" => "#", "title" => "Chefs"],
			];
		} else if ($type == "waiter") {
			$data["header_title"] = "Waiters management";
			$data["breadcrumb_list"] = [
				["uri" => site_url("cms/dashboard"), "title" => "Home"],
				["uri" => "#", "title" => "Waiters"],
			];
		} else {
			$data["header_title"] = "Managers management";
			$data["breadcrumb_list"] = [
				["uri" => site_url("cms/dashboard"), "title" => "Home"],
				["uri" => "#", "title" => "Managers"],
			];
		}

		$data["type"] = $type;
		$data["main_view"] = "cms/staffs/home";
		
		if (!in_role(["admin"])) {
			$data["staffs_list"] = $this->M_Staff->set_role($type)->gets_all(["branch" => $_SESSION["cms_ubranch"]]);
		} else {
			$data["staffs_list"] = $this->M_Staff->set_role($type)->gets_all();
		}
		
		$this->load->model("M_Branch");

		$this->load->view("cms/layout/main", $data);
	}

	public function add() {

		if (isset($_GET["type"]) && $_GET["type"] == "chef") {
			$type = "chef";
		} else if (isset($_GET["type"]) && $_GET["type"] == "waiter") {
			$type = "waiter";
		} else {
			$type = "manager";
			if (!in_role(["admin"])) {
				redirect(site_url("cms/staffs?type=chef"));
				return;
			}
		}

		if ($type == "chef") {
			$data["header_title"] = "Chefs management";
			$data["breadcrumb_list"] = [
				["uri" => site_url("cms/dashboard"), "title" => "Home"],
				["uri" => site_url("cms/staffs?type=".$type), "title" => "Chefs"],
				["uri" => "#", "title" => "Add Chef"],
			];
		} else if ($type == "waiter") {
			$data["header_title"] = "Waiters management";
			$data["breadcrumb_list"] = [
				["uri" => site_url("cms/dashboard"), "title" => "Home"],
				["uri" => site_url("cms/staffs?type=".$type), "title" => "Waiters"],
				["uri" => "#", "title" => "Add Waiter"],
			];
		} else {
			$data["header_title"] = "Managers management";
			$data["breadcrumb_list"] = [
				["uri" => site_url("cms/dashboard"), "title" => "Home"],
				["uri" => site_url("cms/staffs?type=".$type), "title" => "Managers"],
				["uri" => "#", "title" => "Add Manager"],
			];
		}

		$this->load->model("M_Branch");
		if (!in_role(["admin"])) {
			$data["branch_list"] = $this->M_Branch->gets_all([
				"status" => M_Branch::STATUS_ACTIVE,
				"id" => $_SESSION["cms_ubranch"]
			]);
		} else {
			$data["branch_list"] = $this->M_Branch->gets_all(["status" => M_Branch::STATUS_ACTIVE]);
		}

		$data["type"] = $type;
        $data["main_view"] = "cms/staffs/add";
		$this->load->view("cms/layout/main", $data);
	}

	public function edit($id=null) {

		if (isset($_GET["type"]) && $_GET["type"] == "chef") {
			$type = "chef";
		} else if (isset($_GET["type"]) && $_GET["type"] == "waiter") {
			$type = "waiter";
		} else {
			$type = "manager";
			if (!in_role(["admin"])) {
				redirect(site_url("cms/staffs?type=chef"));
				return;
			}
		}

		if (!$id) {
			redirect(site_url("cms/staffs?type=".$type));
			return;
		}

		if ($type == "chef") {
			$data["header_title"] = "Chefs management";
			$data["breadcrumb_list"] = [
				["uri" => site_url("cms/dashboard"), "title" => "Home"],
				["uri" => site_url("cms/staffs?type=".$type), "title" => "Chefs"],
				["uri" => "#", "title" => "Add Chef"],
			];
		} else if ($type == "waiter") {
			$data["header_title"] = "Waiters management";
			$data["breadcrumb_list"] = [
				["uri" => site_url("cms/dashboard"), "title" => "Home"],
				["uri" => site_url("cms/staffs?type=".$type), "title" => "Waiters"],
				["uri" => "#", "title" => "Add Waiter"],
			];
		} else {
			$data["header_title"] = "Managers management";
			$data["breadcrumb_list"] = [
				["uri" => site_url("cms/dashboard"), "title" => "Home"],
				["uri" => site_url("cms/staffs?type=".$type), "title" => "Managers"],
				["uri" => "#", "title" => "Add Manager"],
			];
		}

		$this->load->model("M_Branch");
		if (!in_role(["admin"])) {
			$data["branch_list"] = $this->M_Branch->gets_all([
				"status" => M_Branch::STATUS_ACTIVE,
				"id" => $_SESSION["cms_ubranch"]
			]);
		} else {
			$data["branch_list"] = $this->M_Branch->gets_all(["status" => M_Branch::STATUS_ACTIVE]);
		}

		$data["staff"] = $this->M_Staff->get($id);

		if (!in_role(["admin"]) && $data["staff"]->branch != $_SESSION["cms_ubranch"]) {
			redirect(site_url("cms/staffs?type=".$type));
			return;
		}
		
		$data["type"] = $type;
        $data["main_view"] = "cms/staffs/add";
		$this->load->view("cms/layout/main", $data);
	}

	public function save($id=null) {

		if (isset($_GET["type"]) && $_GET["type"] == "chef") {
			$type = "chef";
		} else if (isset($_GET["type"]) && $_GET["type"] == "waiter") {
			$type = "waiter";
		} else {
			$type = "manager";
			if (!in_role(["admin"])) {
				redirect(site_url("cms/staffs?type=chef"));
				return;
			}
		}

		$is_correct_form = $this->check_form();
		if ($is_correct_form) {
			if ($id) {
				$this->M_Staff->update($id);
				raise_message_ok("Updated successfully");
				redirect(site_url("cms/staffs/edit/".$id."?type=".$type));
			} else {
				$this->M_Staff->set_role($type)->add();
				raise_message_ok("Added successfully");
				redirect(site_url("cms/staffs/add?type=".$type));
			}
		} else {
			raise_message_err("Your form is not valid");
			redirect(site_url("cms/staffs/add?type=".$type));
		}
	}
	
	public function check_form() {

		$email = $this->input->post("email");
		$name = $this->input->post("name");
		$phone = $this->input->post("phone");
		$idc = $this->input->post("idc");
		$gender = $this->input->post("gender");
		$birthday = $this->input->post("birthday");
		$salary = $this->input->post("salary");

		if (strlen(trim($name)) == 0) {
			raise_message_err("Please type the name");
			echo $this->load->view("cms/layout/message_box", null, true);
			return false;
		}

		if (!preg_match('/^[0-9]{10}$/', $phone)) {
            raise_message_err("Please type the correct phone number");
			echo $this->load->view("cms/layout/message_box", null, true);
			return false;
        }

		if (strlen(trim($idc)) == 0) {
			raise_message_err("Please type the identity card");
			echo $this->load->view("cms/layout/message_box", null, true);
			return false;
		}

		if (!isset($gender)) {
			raise_message_err("Please choose gender");
			echo $this->load->view("cms/layout/message_box", null, true);
			return false;
		}

		if (strlen(trim($birthday)) == 0) {
			raise_message_err("Please type the birthday");
			echo $this->load->view("cms/layout/message_box", null, true);
			return false;
		}

		if (!(filter_var($salary, FILTER_VALIDATE_INT) && $salary > 0)) {
			raise_message_err("Please type a correct salary");
			echo $this->load->view("cms/layout/message_box", null, true);
			return false;
		}

		$existed_account = $this->M_Staff->is_existed($email, $phone, $idc);
		if ($existed_account) {
			raise_message_err("This phone and IDC has existed in the system");
			echo $this->load->view("cms/layout/message_box", null, true);
			return false;
		}
		
		echo "ok";
		return true;
	}

	public function change_status($id=null) {
		if ($id) {
			$this->M_Staff->change_status($id);
			alert_message_box("Updated successfully");
		}
		redirect(site_url("cms/staffs?type=".$_GET["type"]));
	}

	public function reset_password($id=null) {
		if ($id) {
			$this->M_Staff->reset_password($id);
			alert_message_box("Reset successfully");
		}
		redirect(site_url("cms/staffs?type=".$_GET["type"]));
	}

	public function delete($id=null) {
		if ($id) {
			$this->M_Staff->delete($id);
			alert_message_box("Deleted successfully");
		}
		redirect(site_url("cms/staffs?type=".$_GET["type"]));
	}

	public function pay_salary($id=null) {
		if ($id) {
			$this->M_Staff->pay_salary($id);
			alert_message_box("Paid successfully");
		}
		redirect(site_url("cms/statistics/salary"));
	}
	
}
