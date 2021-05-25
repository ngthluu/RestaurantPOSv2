<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CMS_Controllers {

	public function index() {
		$data["header_title"] = "Dashboard";
		$data["breadcrumb_list"] = [
			["uri" => site_url("cms/dashboard"), "title" => "Home"],
			["uri" => "#", "title" => "Dashboard"],
		];
        $data["main_view"] = "cms/dashboard/home";
		$this->load->view("cms/layout/main", $data);
	}

	public function profile() {
		$data["header_title"] = "Profile";
		$data["breadcrumb_list"] = [
			["uri" => site_url("cms/dashboard"), "title" => "Home"],
			["uri" => "#", "title" => "Profile"],
		];
        $data["main_view"] = "cms/profile/home";

		$this->load->model("M_Staff");
		$data["staff"] = $this->M_Staff->get($_SESSION["cms_uid"]);

		$this->load->view("cms/layout/main", $data);
	}

	public function profile_save() {
		$this->load->model("M_Staff");
		$is_correct_form = $this->profile_check_form();
		if ($is_correct_form) {
			$this->M_Staff->update_profile($_SESSION["cms_uid"]);
			raise_message_ok("Updated successfully");

			// Reset session
			$reset_session = $this->M_Staff->reset_session();
			if (!$reset_session) {
				redirect(site_url("cms/auth/signout"));
				return;
			}

			redirect(site_url("cms/profile"));
		} else {
			raise_message_err("Your form is not valid");
			redirect(site_url("cms/profile"));
		}
	}

	public function profile_check_form() {

		$this->load->model("M_Staff");
		
		$email = $this->input->post("email");
		$name = $this->input->post("name");
		$phone = $this->input->post("phone");
		$idc = $this->input->post("idc");
		$gender = $this->input->post("gender");
		$birthday = $this->input->post("birthday");
		$password = $this->input->post("password");
		$repassword = $this->input->post("repassword");

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

		if (strlen($password) > 0 && strlen($password) < 6) {
			raise_message_err("Your password length must be greater than 5");
			echo $this->load->view("cms/layout/message_box", null, true);
			return false;
		}

		if (strlen($password) > 0 && $password != $repassword) {
			raise_message_err("Your re typed password is not match");
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

	public function register_notification() {
		$this->load->model("M_Staff");
		$uid = $this->input->post("uid");
		$this->M_Staff->register_notification($_SESSION["cms_uid"], $uid);
		echo "ok";
	}
}
