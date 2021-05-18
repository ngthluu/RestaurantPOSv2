<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Admin extends CI_Model {

	public function __construct() {
        parent::__construct();
        $this->table = $this->db->dbprefix("staffs");
        $this->db->where("role", "admin");
    }

    public function create_account() {
        $is_existed = $this->db->get_where($this->table);
        $this->db->flush_cache();
        if ($is_existed->num_rows() == 0) {
            // Create admin account here
            $new_data = array(
                "phone"     => "1234567890",
                "password"  => hashing_password("123456"),
                "email"     => "admin@pos.v2",
                "name"      => "Super admin",
                "role"      => "admin"
            );
            $this->db->insert($this->table, $new_data);
            $this->reset_connection();
            return true;
        }
        $this->reset_connection();
        return false;
    }

    public function signin($email, $password) {
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
        $_SESSION["cms_urole"] = "admin";
        $_SESSION["cms_ubranch"] = $user->branch;

        $this->reset_connection();
        return true;
    }

    private function reset_connection() {
        $this->db->close();
        $this->db->initialize();
    }
}
