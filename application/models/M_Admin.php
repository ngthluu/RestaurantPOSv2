<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Admin extends CI_Model {

    private const ROLE = "admin";
    public const STATUS_PUBLISHED = 1;

    private function init_connection() {
        $this->table = $this->db->dbprefix("staffs");
        $this->where = ["role" => self::ROLE];
        $this->db->where($this->where);
    }

    private function reset_connection() {
        $this->db->close();
        $this->db->initialize();
    }

    public function create_account() {
        $this->init_connection();
        $is_existed = $this->db->get_where($this->table);
        $this->db->flush_cache();
        if ($is_existed->num_rows() == 0) {
            // Create admin account here
            $new_data = [
                "phone"     => "1234567890",
                "password"  => hashing_password("123456"),
                "email"     => "admin@".EMAIL_PATH,
                "name"      => "Super admin",
                "role"      => self::ROLE,
                "status"    => self::STATUS_PUBLISHED
            ];
            $this->db->insert($this->table, $new_data);
            $this->reset_connection();
            return true;
        }
        $this->reset_connection();
        return false;
    }

    public function signin($email, $password) {
        $this->init_connection();
        $is_existed = $this->db->get_where($this->table, [
            "email" => $email,
            "password" => hashing_password($password),
            "status" => self::STATUS_PUBLISHED
        ]);
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
