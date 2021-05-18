<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Branch extends CI_Model {

    private function init_connection() {
        $this->table = $this->db->dbprefix("branches");
    }

    private function reset_connection() {
        $this->db->close();
        $this->db->initialize();
    }

    public function gets_all() {
        $this->init_connection();
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

        $this->init_connection();

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

        $this->init_connection();

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
}
