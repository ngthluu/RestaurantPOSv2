<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends SITE_Controllers {

	public function __construct() {
		parent::__construct();

		if (!is_logged_in()) {
			redirect(site_url());
		}

		$this->load->model("M_Customer");
	}

	public function index() {
        $data["main_header"] = "Settings";
        $data["main_view"] = "homepage/settings";

        $data["customer"] = $this->M_Customer->get($_SESSION["uid"]);

		$this->load->view("homepage/layout/main", $data);
	}

    public function check_form() {
		$phone = $this->input->post("phone");
        $email = $this->input->post("email");
		$name = $this->input->post("name");
		$gender = $this->input->post("gender");
		$birthday = $this->input->post("birthday");

		if (strlen(trim($name)) == 0) {
			raise_message_err("Please type the name");
			echo $this->load->view("homepage/layout/message_box", null, true);
			return false;
		}

		if (!preg_match('/^[0-9]{10}$/', $phone)) {
            raise_message_err("Please type the correct phone number");
			echo $this->load->view("homepage/layout/message_box", null, true);
			return false;
        }

		if (!isset($gender)) {
			raise_message_err("Please choose gender");
			echo $this->load->view("homepage/layout/message_box", null, true);
			return false;
		}

		if (strlen(trim($birthday)) == 0) {
			raise_message_err("Please type the birthday");
			echo $this->load->view("homepage/layout/message_box", null, true);
			return false;
		}

		$existed_account = $this->M_Customer->is_existed($phone, $email);
		if ($existed_account) {
			raise_message_err("This email and phone has existed in the system");
			echo $this->load->view("homepage/layout/message_box", null, true);
			return false;
		}
		
		echo "ok";
		return true;
    }

    public function save() {
        $is_correct_form = $this->check_form();
		if ($is_correct_form) {
            $this->M_Customer->update();
            raise_message_ok("Updated successfully");
            redirect(site_url("settings"));
		} else {
			raise_message_err("Your form is not valid");
			redirect(site_url("settings"));
		}
    }

	public function register_notification() {
		$uid = $this->input->post("uid");
		$_SESSION["uid_notification"] = $uid;
		echo "ok";
	}

	public function get_notification_ids() {
		echo isset($_SESSION["uid_notification"]) ? $_SESSION["uid_notification"] : "";
	}
}
