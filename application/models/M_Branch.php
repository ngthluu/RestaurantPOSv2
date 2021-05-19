<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Branch extends CI_Model {

    public const STATUS_PAUSED = 0;
    public const STATUS_ACTIVE = 1;

    private function init_connection() {
        $this->table = $this->db->dbprefix("branches");
        $this->db->reset_query();
        $this->db->order_by("id", "desc");
    }

    private function reset_connection() {
        $this->db->close();
        $this->db->initialize();
    }

    public function gets_all($where=null) {
        $this->init_connection();
        $result = $this->db->get_where($this->table, $where);
        $this->db->flush_cache();
        if ($result->num_rows() == 0) {
            $this->reset_connection();
            return array();
        }
        $this->reset_connection();
        return $result->result();
    }

    public function get($id) {
        $this->init_connection();
        $result = $this->db->get_where($this->table, array("id" => $id));
        $this->db->flush_cache();
        if ($result->num_rows() == 0) {
            $this->reset_connection();
            return null;
        }
        $this->reset_connection();
        return $result->row();
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
            "status"        => self::STATUS_PAUSED
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
            "tables_num"    => $numberOfTables
        );
        $this->db->update($this->table, $new_data, array("id" => $id));
        $this->reset_connection();
        return true;
    }

    public function change_status($id) {
        $this->init_connection();

        $branch = $this->get($id);
        if ($branch->status == self::STATUS_PAUSED) {
            $this->db->update($this->table, array("status" => self::STATUS_ACTIVE), array("id" => $id));
        } else if ($branch->status == self::STATUS_ACTIVE) {
            $this->db->update($this->table, array("status" => self::STATUS_PAUSED), array("id" => $id));
        }

        $this->reset_connection();
        return true;
    }

    public function delete($id) {
        $this->init_connection();
        $this->db->delete($this->table, array("id" => $id));
        $this->reset_connection();
        return true;
    }
}
