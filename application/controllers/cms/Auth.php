<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CMS_Controllers {

    public function __construct() {
        parent::__construct();
        if (cms_is_logged_in() && uri_string() !== "cms/auth/signout") {
            redirect(site_url("cms/dashboard"));
        }
    }

	public function signin()
	{
        $data["header_title"] = "Sign in";
        $data["main_view"] = "cms/auth/signin";
		$this->load->view("cms/layout/main_auth", $data);
	}

    public function signout() {
        unset($_SESSION["cms_uid"]);
        unset($_SESSION["cms_uname"]);
        unset($_SESSION["cms_uemail"]);
        unset($_SESSION["cms_uavatar"]);
        unset($_SESSION["cms_urole"]);
        unset($_SESSION["cms_ubranch"]);
        redirect(site_url("cms/auth/signin"));
    }

    public function create_admin() {
        $this->load->model("M_Admin");
        $result = $this->M_Admin->create_account();
        if ($result) {
            raise_message_ok("Admin account is created successfully");
        } else {
            raise_message_err("Admin account was created");
        }
        redirect(site_url("cms/auth/signin"));
    }

    public function post_signin() {
        $email = $this->input->post("email");
        $password = $this->input->post("password");
        
        $this->load->model("M_Admin");
        $this->load->model("M_Manager");
        $this->load->model("M_Chef");
        $this->load->model("M_Waiter");
        
        if ($this->M_Admin->signin($email, $password)) {
            redirect(site_url("cms/dashboard"));
        } else if ($this->M_Manager->signin($email, $password)) {
            redirect(site_url("cms/dashboard"));
        } else if ($this->M_Chef->signin($email, $password)) {
            redirect(site_url("cms/dashboard"));
        } else if ($this->M_Waiter->signin($email, $password)) {
            redirect(site_url("cms/dashboard"));
        } else {
            raise_message_err("Your email/password is not correct");
            redirect(site_url("cms/auth/signin"));
        }
    }
}
