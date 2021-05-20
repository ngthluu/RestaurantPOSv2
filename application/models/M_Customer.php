<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Customer extends CI_Model {

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

    public function signin($phone, $password) {
        $this->init_connection();
        $is_existed = $this->db->get_where($this->table, [
            "phone" => $phone,
            "password" => hashing_password($password),
            "status" => self::STATUS_PUBLISHED
        ]);
        $this->db->flush_cache();
        if ($is_existed->num_rows() == 0) {
            $this->reset_connection();
            return false;
        }

        // Logged in, set session
        $customer = $is_existed->row();
        $_SESSION["uid"] = $customer->id;
        $_SESSION["uname"] = $customer->name;
        $_SESSION["uphone"] = $customer->phone;
        $_SESSION["uavatar"] = $customer->avatar ? base_url("resources/customers/".$customer->id."/".$customer->avatar) : base_url("resources/no-avatar.png");

        $this->reset_connection();
        return true;
    }

    public function is_existed($phone) {
        $this->init_connection();
        $is_existed = $this->db->get_where($this->table, array("phone" => $phone));
        $this->db->flush_cache();
        if ($is_existed->num_rows() == 0) {
            $this->reset_connection();
            return false;
        }
        $this->reset_connection();
        return true;
    }

    public function add() {

        $this->init_connection();

        $name = random_string('alnum', 10);
		$phone = $this->input->post("phone");
        $password = $this->input->post("password");

        $new_data = [
            "phone"         => $phone,
            "password"      => hashing_password($password),
            "email"         => $name.'@'.EMAIL_PATH,
            "name"          => $name,
            "status"        => self::STATUS_PUBLISHED
        ];
        $this->db->insert($this->table, $new_data);
        
        $id = $this->db->insert_id();

        $this->reset_connection();
        return $id;
    }
}
