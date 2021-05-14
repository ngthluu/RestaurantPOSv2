<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CMS_Controllers {

	public function signin()
	{
        $data["header_title"] = "Sign in";
        $data["main_view"] = "cms/auth/signin";
		$this->load->view("cms/layout/main_auth", $data);
	}
}
