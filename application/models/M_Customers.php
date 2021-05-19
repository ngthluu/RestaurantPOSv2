<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Customers extends CI_Model {

    public const STATUS_LOCKED = 0;
    public const STATUS_PUBLISHED = 1;

    private function init_connection() {
        $this->table = $this->db->dbprefix("customers");
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
            return [];
        }
        $this->reset_connection();
        return $result->result();
    }

    public function get($id, $where=null) {
        $this->init_connection();
        $w = ["id" => $id];
        if ($where) {
            $w = array_merge($w, $where);
        }
        $result = $this->db->get_where($this->table, $w);
        $this->db->flush_cache();
        if ($result->num_rows() == 0) {
            $this->reset_connection();
            return null;
        }
        $this->reset_connection();
        return $result->row();
    }

    public function change_status($id) {
        $this->init_connection();
        $customer = $this->get($id);
        if ($customer->status == self::STATUS_LOCKED) {
            $this->db->update($this->table, ["status" => self::STATUS_PUBLISHED], ["id" => $id]);
        } else if ($customer->status == self::STATUS_PUBLISHED) {
            $this->db->update($this->table, ["status" => self::STATUS_LOCKED], ["id" => $id]);
        }

        $this->reset_connection();
        return true;
    }

    public function delete($id) {
        $this->init_connection();
        $this->db->delete($this->table, ["id" => $id]);
        $this->reset_connection();
        return true;
    }
}
