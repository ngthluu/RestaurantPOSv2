<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Manager extends CI_Model {

    private const ROLE = "manager";

    private function init_connection() {
        $this->table = $this->db->dbprefix("staffs");
        $this->where = array("role" => self::ROLE);
        $this->db->where($this->where);
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

    public function signin($email, $password) {
        $this->init_connection();
        $is_existed = $this->db->get_where($this->table, array(
            "email" => $email,
            "password" => hashing_password($password)
        ));
        $this->db->flush_cache();
        if ($is_existed->num_rows() == 0) {
            $this->reset_connection();
            return false;
        }

        // Logged in, set session
        $user = $is_existed->row();
        $_SESSION["cms_uid"] = $user->id;
        $_SESSION["cms_uname"] = $user->name;
        $_SESSION["cms_uemail"] = $user->email;
        $_SESSION["cms_uavatar"] = $user->avatar ? base_url("resources/users/".$user->id."/".$user->avatar) : base_url("resources/no-avatar.png");
        $_SESSION["cms_urole"] = self::ROLE;
        $_SESSION["cms_ubranch"] = $user->branch;

        $this->reset_connection();
        return true;
    }
}
