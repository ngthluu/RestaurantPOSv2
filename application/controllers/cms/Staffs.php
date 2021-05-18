<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Staffs extends CMS_Controllers {

	public function index() {

		// Load models
		if (isset($_GET["type"]) && $_GET["type"] == "chef") {
			$this->load->model("M_Chef", "M_Staff");
			$type = "chef";
		} else if (isset($_GET["type"]) && $_GET["type"] == "waiter") {
			$this->load->model("M_Waiter", "M_Staff");
			$type = "waiter";
		} else {
			$this->load->model("M_Manager", "M_Staff");
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

		$data["staffs_list"] = $this->M_Staff->gets_all();
		$this->load->model("M_Branch");

		$this->load->view("cms/layout/main", $data);
	}

	public function add() {

		// Load models
		if (isset($_GET["type"]) && $_GET["type"] == "chef") {
			$this->load->model("M_Chef", "M_Staff");
			$type = "chef";
		} else if (isset($_GET["type"]) && $_GET["type"] == "waiter") {
			$this->load->model("M_Waiter", "M_Staff");
			$type = "waiter";
		} else {
			$this->load->model("M_Manager", "M_Staff");
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

	public function save($id=null) {

		// Load models
		if (isset($_GET["type"]) && $_GET["type"] == "chef") {
			$this->load->model("M_Chef", "M_Staff");
			$type = "chef";
		} else if (isset($_GET["type"]) && $_GET["type"] == "waiter") {
			$this->load->model("M_Waiter", "M_Staff");
			$type = "waiter";
		} else {
			$this->load->model("M_Manager", "M_Staff");
			$type = "manager";
		}

		$is_correct_form = $this->check_form();
		if ($is_correct_form) {
			if ($id) {
				$this->M_Staff->update($id);
				raise_message_ok("Updated successfully");
				redirect(site_url("cms/staffs/edit/".$id."?type=".$type));
			} else {
				$this->M_Staff->add();
				raise_message_ok("Added successfully");
				redirect(site_url("cms/staffs/add?type=".$type));
			}
		} else {
			raise_message_err("Your form is not valid");
			redirect(site_url("cms/staffs/add?type=".$type));
		}
	}
	
	public function check_form() {

		// Load models
		if (isset($_GET["type"]) && $_GET["type"] == "chef") {
			$this->load->model("M_Chef", "M_Staff");
		} else if (isset($_GET["type"]) && $_GET["type"] == "waiter") {
			$this->load->model("M_Waiter", "M_Staff");
		} else {
			$this->load->model("M_Manager", "M_Staff");
		}

		$name = $this->input->post("name");
		$phone = $this->input->post("phone");
		$idc = $this->input->post("idc");
		$gender = $this->input->post("gender");
		$birthday = $this->input->post("birthday");
		$branch = $this->input->post("branch");

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

		if (!isset($branch)) {
			raise_message_err("Please choose a branch");
			echo $this->load->view("cms/layout/message_box", null, true);
			return false;
		}

		$existed_account = $this->M_Staff->is_existed($phone, $idc);
		if ($existed_account) {
			raise_message_err("This account existed in the system");
			echo $this->load->view("cms/layout/message_box", null, true);
			return false;
		}
		
		echo "ok";
		return true;
	}
}
