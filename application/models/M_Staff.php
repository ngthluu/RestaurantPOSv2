<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Staff extends CI_Model {

    private $role = "staff";
    public const STATUS_LOCKED = 0;
    public const STATUS_PUBLISHED = 1;

    private function init_connection($reset_where = false) {
        $this->table = $this->db->dbprefix("staffs");
        $this->where = array("role" => $this->role);
        $this->db->where($this->where);
        if ($reset_where) {
            $this->db->reset_query();
        }
    }

    private function reset_connection() {
        $this->db->close();
        $this->db->initialize();
    }

    public function set_role($role) {
        $this->role = $role;
        return $this;
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

    public function get($id, $where=null) {
        $this->init_connection(true);
        $w = array("id" => $id);
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

    public function signin($email, $password) {
        $this->init_connection(true);
        $is_existed = $this->db->get_where($this->table, array(
            "email" => $email,
            "password" => hashing_password($password),
            "status" => self::STATUS_PUBLISHED
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
        $_SESSION["cms_urole"] = $user->role;
        $_SESSION["cms_ubranch"] = $user->branch;

        $this->reset_connection();
        return true;
    }

    private function get_count() {
        $this->init_connection(true);
        $result = $this->db->get_where($this->table);
        $this->db->flush_cache();
        $result = $result->num_rows();
        $this->reset_connection();
        return $result;
    }

    private function uploadImage($id) {
        $this->init_connection();
        $avatar = uploadImage("./resources/users/".$id."/", "avatar-file");
        if ($avatar && $avatar != "") {
            $this->db->update($this->table, array("avatar" => $avatar), array("id" => $id));
        }
        $this->reset_connection();
    } 

    public function is_existed($email, $phone, $idc) {
        $this->init_connection(true);
        if ($email == "") {
            $this->db->where("phone", $phone);
            $this->db->or_where("idc", $idc);
        } else {
            $this->db->where("email != ", $email)
                ->group_start()
                ->where("phone", $phone)
                ->or_where("idc", $idc)
                ->group_end();
        }
        
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

        $email = $this->role.date("dmy").sprintf('%03d', $this->get_count() + 1)."@".EMAIL_PATH;
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
            "role"          => $this->role,
            "status"        => self::STATUS_LOCKED,
            "create_by"    => $_SESSION["cms_uid"]
        );
        $this->db->insert($this->table, $new_data);
        
        $id = $this->db->insert_id();

        $this->uploadImage($id);

        $this->reset_connection();
        return $id;
    }

    public function update($id) {

        $this->init_connection(true);

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

        $this->uploadImage($id);

        $this->reset_connection();
        return true;
    }

    public function change_status($id) {
        $this->init_connection(true);
        $staff = $this->get($id);
        if ($staff->status == self::STATUS_LOCKED) {
            // Update branch manager
            if ($staff->role == "manager") {
                $this->db->update($this->db->dbprefix("branches"), array("manager" => $staff->id), array("id" => $staff->branch));
            } 
            $this->db->update($this->table, array("status" => self::STATUS_PUBLISHED), array("id" => $id));
        } else if ($staff->status == self::STATUS_PUBLISHED) {
            $this->db->update($this->table, array("status" => self::STATUS_LOCKED), array("id" => $id));
        }

        $this->reset_connection();
        return true;
    }

    public function reset_password($id) {
        $this->init_connection(true);
        $this->db->update($this->table, array("password" => hashing_password("123456")), array("id" => $id));
        $this->reset_connection();
        return true;
    }

    public function delete($id) {
        $this->init_connection(true);
        $this->db->delete($this->table, array("id" => $id));
        $this->reset_connection();
        return true;
    }
}
