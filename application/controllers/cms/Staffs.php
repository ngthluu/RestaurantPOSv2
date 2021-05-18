<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Staffs extends CMS_Controllers {

	public function __construct() {
		parent::__construct();

		$this->load->model("M_Staff");
	}

	public function index() {

		if (isset($_GET["type"]) && $_GET["type"] == "chef") {
			$type = "chef";
		} else if (isset($_GET["type"]) && $_GET["type"] == "waiter") {
			$type = "waiter";
		} else {
			$type = "manager";
		}

		if ($type == "chef") {
			$data["header_title"] = "Chefs management";
			$data["breadcrumb_list"] = array(
				array("uri" => site_url("cms/dashboard"), "title" => "Home"),
				array("uri" => "#", "title" => "Chefs"),
			);
		} else if ($type == "waiter") {
			$data["header_title"] = "Waiters management";
			$data["breadcrumb_list"] = array(
				array("uri" => site_url("cms/dashboard"), "title" => "Home"),
				array("uri" => "#", "title" => "Waiters"),
			);
		} else {
			$data["header_title"] = "Managers management";
			$data["breadcrumb_list"] = array(
				array("uri" => site_url("cms/dashboard"), "title" => "Home"),
				array("uri" => "#", "title" => "Managers"),
			);
		}

		$data["type"] = $type;
		$data["main_view"] = "cms/staffs/home";

		$data["staffs_list"] = $this->M_Staff->set_role($type)->gets_all();
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
		}

		if ($type == "chef") {
			$data["header_title"] = "Chefs management";
			$data["breadcrumb_list"] = array(
				array("uri" => site_url("cms/dashboard"), "title" => "Home"),
				array("uri" => site_url("cms/staffs?type=".$type), "title" => "Chefs"),
				array("uri" => "#", "title" => "Add Chef"),
			);
		} else if ($type == "waiter") {
			$data["header_title"] = "Waiters management";
			$data["breadcrumb_list"] = array(
				array("uri" => site_url("cms/dashboard"), "title" => "Home"),
				array("uri" => site_url("cms/staffs?type=".$type), "title" => "Waiters"),
				array("uri" => "#", "title" => "Add Waiter"),
			);
		} else {
			$data["header_title"] = "Managers management";
			$data["breadcrumb_list"] = array(
				array("uri" => site_url("cms/dashboard"), "title" => "Home"),
				array("uri" => site_url("cms/staffs?type=".$type), "title" => "Managers"),
				array("uri" => "#", "title" => "Add Manager"),
			);
		}

		$this->load->model("M_Branch");
		$data["branch_list"] = $this->M_Branch->gets_all(array("status" => M_Branch::STATUS_ACTIVE));
		
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
		}

		if (!$id) {
			redirect(site_url("cms/staffs?type=".$type));
			return;
		}

		if ($type == "chef") {
			$data["header_title"] = "Chefs management";
			$data["breadcrumb_list"] = array(
				array("uri" => site_url("cms/dashboard"), "title" => "Home"),
				array("uri" => site_url("cms/staffs?type=".$type), "title" => "Chefs"),
				array("uri" => "#", "title" => "Add Chef"),
			);
		} else if ($type == "waiter") {
			$data["header_title"] = "Waiters management";
			$data["breadcrumb_list"] = array(
				array("uri" => site_url("cms/dashboard"), "title" => "Home"),
				array("uri" => site_url("cms/staffs?type=".$type), "title" => "Waiters"),
				array("uri" => "#", "title" => "Add Waiter"),
			);
		} else {
			$data["header_title"] = "Managers management";
			$data["breadcrumb_list"] = array(
				array("uri" => site_url("cms/dashboard"), "title" => "Home"),
				array("uri" => site_url("cms/staffs?type=".$type), "title" => "Managers"),
				array("uri" => "#", "title" => "Add Manager"),
			);
		}

		$this->load->model("M_Branch");
		$data["branch_list"] = $this->M_Branch->gets_all(array("status" => M_Branch::STATUS_ACTIVE));

		$data["staff"] = $this->M_Staff->get($id);
		
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

		$existed_account = $this->M_Staff->is_existed($email, $phone, $idc);
		if ($existed_account) {
			raise_message_err("This account existed in the system");
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
	
}
