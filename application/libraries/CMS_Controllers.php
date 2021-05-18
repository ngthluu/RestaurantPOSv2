<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class CMS_Controllers extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->auth_middleware();
    }

    private function auth_middleware() {
        if (!($this->uri->segment(1) == "cms" && $this->uri->segment(2) == "auth")) {
            if (!cms_is_logged_in()) {
                redirect(site_url('cms/auth/signin'));
            }
        }
    }

}