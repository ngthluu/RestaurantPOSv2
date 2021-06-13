<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends SITE_Controllers {

	public function __construct() {
		parent::__construct();
        $this->load->model("M_Menu");
	}

	public function view($menu_id=null) {

        if (!($menu_id && filter_var($menu_id, FILTER_VALIDATE_INT))) {
            redirect(site_url("404_error"));
            return;
        }
        
        $data["main_header"] = "Menu";
        $data["main_view"] = "homepage/menu";

        $data["menu"] = $this->M_Menu->get($menu_id);

		$this->load->view("homepage/layout/main", $data);
	}
}
