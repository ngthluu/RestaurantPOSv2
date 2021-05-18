<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Manager extends CI_Model {

	public function __construct() {
        parent::__construct();
        $this->table = $this->db->dbprefix("staffs");
        $this->db->where("role", "manager");
    }

    public function gets_all() {
        $result = $this->db->get_where($this->table);
        $this->db->flush_cache();
        if ($result->num_rows() == 0) {
            $this->reset_connection();
            return array();
        }
        $this->reset_connection();
        return $result->result();
    }

    private function reset_connection() {
        $this->db->close();
        $this->db->initialize();
    }
}
