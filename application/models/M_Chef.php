<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Chef extends CI_Model {

    private const ROLE = "chef";
    public const STATUS_LOCKED = 0;
    public const STATUS_PUBLISHED = 0;

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

    private function get_count() {
        $this->init_connection();
        $result = $this->db->get_where($this->table);
        $this->db->flush_cache();
        $result = $result->num_rows();
        $this->reset_connection();
        return $result;
    }

    public function is_existed($phone, $idc) {
        $this->init_connection();
        $this->db->reset_query();
        $this->db->where("phone", $phone);
        $this->db->or_where("idc", $idc);
        $is_existed = $this->db->get_where($this->table);
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

        $email = self::ROLE.date("dmyy").sprintf('%03d', $this->get_count() + 1)."@".EMAIL_PATH;
        $name = $this->input->post("name");
		$phone = $this->input->post("phone");
		$idc = $this->input->post("idc");
		$gender = $this->input->post("gender");
		$birthday = $this->input->post("birthday");
		$branch = $this->input->post("branch");

        $new_data = array(
            "phone"         => $phone,
            "password"      => hashing_password("123456"),
            "email"         => $email,
            "name"          => $name,
            "idc"           => $idc,
            "gender"        => $gender,
            "birthday"      => $birthday,
            "branch"        => $branch,
            "role"          => self::ROLE,
            "status"        => self::STATUS_LOCKED,
            "create_by"    => $_SESSION["cms_uid"]
        );
        $this->db->insert($this->table, $new_data);
        
        $id = $this->db->insert_id();

        // Upload avatar
        $avatar = uploadImage("./resources/users".$id."/", "avatar-file");
        if ($avatar && $avatar != "") {
            $this->db->update($this->table, array("avatar" => $avatar), array("id" => $id));
        }

        $this->reset_connection();
        return $id;
    }

    public function update($id) {

        $this->init_connection();

        $name = $this->input->post("name");
		$phone = $this->input->post("phone");
		$idc = $this->input->post("idc");
		$gender = $this->input->post("gender");
		$birthday = $this->input->post("birthday");
		$branch = $this->input->post("branch");

        $new_data = array(
            "phone"         => $phone,
            "name"          => $name,
            "idc"           => $idc,
            "gender"        => $gender,
            "birthday"      => $birthday,
            "branch"        => $branch,
        );

        $this->db->update($this->table, $new_data, array("id" => $id));
        $this->reset_connection();
        return true;
    }
}
