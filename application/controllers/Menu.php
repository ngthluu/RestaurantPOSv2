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

    function submit_Feedback($menu_id=null) {
        if (!($menu_id && filter_var($menu_id, FILTER_VALIDATE_INT))) {
            echo json_encode(['status' => 'error']);
            return;
        }
        
        $rating = $this->input->post("rating");
        $comment = $this->input->post("comment");

        $this->load->model('M_Customer');
        $customer = $this->input->post("customer");
        $customer = $this->M_Customer->get($customer);


        echo json_encode(['status' => 'ok', 'data' => [
            'customer' => [
                'image' => $customer->avatar ? base_url("resources/customers/".$customer->id."/".$customer->avatar) : base_url("resources/no-avatar.png"), 
                'name' => $customer->name
            ],
            'rating' => $rating,
            'comment' => $comment
        ]]);
    }

    function fetch_Feedbacks($menu_id=null) {
        if (!($menu_id && filter_var($menu_id, FILTER_VALIDATE_INT))) {
            echo json_encode(['status' => 'error']);
            return;
        }
        $feedbacks = $this->M_Menu->get_feedbacks($menu_id);
        if (empty($feedbacks)) {
            echo json_encode(['status' => 'empty']);
            return;
        }
        echo json_encode(['status' => 'fetch', 'data' => $feedbacks]);
    }
}
