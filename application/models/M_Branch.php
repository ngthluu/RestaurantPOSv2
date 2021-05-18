<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Branch extends CI_Model {

	public function __construct() {
        parent::__construct();
        $this->table = $this->db->dbprefix("branches");
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

    public function add() {
        $name = $this->input->post("name");
		$address = $this->input->post("address");
		$numberOfTables = $this->input->post("tablesNum");
		$manager = $this->input->post("manager");

        $new_data = array(
            "name"          => $name,
            "address"       => $address,
            "manager"       => isset($manager) && $manager ? $manager : 1,
            "tables_num"    => $numberOfTables,
            "status"        => 0
        );
        $this->db->insert($this->table, $new_data);
        
        $id = $this->db->insert_id();

        $this->reset_connection();
        return $id;
    }

    public function update($id) {
        $name = $this->input->post("name");
		$address = $this->input->post("address");
		$numberOfTables = $this->input->post("tablesNum");
		$manager = $this->input->post("manager");

        $new_data = array(
            "name"          => $name,
            "address"       => $address,
            "manager"       => isset($manager) && $manager ? $manager : 1,
            "tables_num"    => $numberOfTables,
            "status"        => 0
        );
        $this->db->update($this->table, $new_data, array("id" => $id));
        $this->reset_connection();
        return true;
    }

    private function reset_connection() {
        $this->db->close();
        $this->db->initialize();
    }
}
