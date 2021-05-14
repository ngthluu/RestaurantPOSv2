<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CMS_Controllers {

	public function index()
	{
		$this->load->view("cms/layout/main");
	}

	public function not_found() {
		
	}
}
