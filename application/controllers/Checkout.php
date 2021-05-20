<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checkout extends SITE_Controllers {

	public function __construct() {
		parent::__construct();

		if (!is_logged_in()) {
			redirect(site_url());
		}
	}

	public function index() {
        var_dump($_SESSION["cart"]);
	}
}
