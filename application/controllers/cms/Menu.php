<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CMS_Controllers {

	public function __construct() {
		parent::__construct();

		$this->load->model("M_Menu");
	}

	public function index() {

		$data["header_title"] = "Menu management";
		$data["breadcrumb_list"] = array(
			array("uri" => site_url("cms/dashboard"), "title" => "Home"),
			array("uri" => "#", "title" => "Menu"),
		);

		$data["main_view"] = "cms/menu/home";
		$data["menu_list"] = $this->M_Menu->gets_all();
		$this->load->model("M_Branch");

		$this->load->view("cms/layout/main", $data);
	}

	public function add() {

		$data["header_title"] = "Menu management";
		$data["breadcrumb_list"] = array(
			array("uri" => site_url("cms/dashboard"), "title" => "Home"),
			array("uri" => site_url("cms/menu"), "title" => "Menu"),
			array("uri" => "#", "title" => "Add Menu"),
		);

		$this->load->model("M_Branch");
		$data["branch_list"] = $this->M_Branch->gets_all(array("status" => M_Branch::STATUS_ACTIVE));
		
        $data["main_view"] = "cms/menu/add";
		$this->load->view("cms/layout/main", $data);
	}

	public function edit($id=null) {

		if (!$id) {
			redirect(site_url("cms/menu"));
			return;
		}

		$data["header_title"] = "Menu management";
		$data["breadcrumb_list"] = array(
			array("uri" => site_url("cms/dashboard"), "title" => "Home"),
			array("uri" => site_url("cms/menu"), "title" => "Menu"),
			array("uri" => "#", "title" => "Edit Menu"),
		);

		$this->load->model("M_Branch");
		$data["branch_list"] = $this->M_Branch->gets_all(array("status" => M_Branch::STATUS_ACTIVE));

		$data["menu"] = $this->M_Menu->get($id);
		
        $data["main_view"] = "cms/menu/add";
		$this->load->view("cms/layout/main", $data);
	}

	public function save($id=null) {

		$is_correct_form = $this->check_form();
		if ($is_correct_form) {
			if ($id) {
				$this->M_Menu->update($id);
				raise_message_ok("Updated successfully");
				redirect(site_url("cms/menu/edit/".$id));
			} else {
				$this->M_Menu->add();
				raise_message_ok("Added successfully");
				redirect(site_url("cms/menu/add"));
			}
		} else {
			raise_message_err("Your form is not valid");
			redirect(site_url("cms/menu/add"));
		}
	}
	
	public function check_form() {

		$name = $this->input->post("name");
		$price = $this->input->post("price");

		if (strlen(trim($name)) == 0) {
			raise_message_err("Please type the name");
			echo $this->load->view("cms/layout/message_box", null, true);
			return false;
		}

		if (!(filter_var($price, FILTER_VALIDATE_INT) && $price > 0)) {
			raise_message_err("Please type the correct price value");
			echo $this->load->view("cms/layout/message_box", null, true);
			return false;
		}
		
		echo "ok";
		return true;
	}

	public function change_status($id=null) {
		if ($id) {
			$this->M_Menu->change_status($id);
			alert_message_box("Updated successfully");
		}
		redirect(site_url("cms/menu"));
	}

	public function change_status_date($id=null) {
		if ($id) {
			$this->M_Menu->change_status_date($id);
			alert_message_box("Updated successfully");
		}
		redirect(site_url("cms/menu"));
	}

	public function delete($id=null) {
		if ($id) {
			$this->M_Menu->delete($id);
			alert_message_box("Deleted successfully");
		}
		redirect(site_url("cms/menu"));
	}
	
}
