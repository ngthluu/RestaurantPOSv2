<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends SITE_Controllers {

	public function index()
	{
		redirect(site_url("cms/auth/signin"));
	}

	public function not_found() {
		
	}
}
