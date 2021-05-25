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

    public function gets_count($where=null) {
        $this->init_connection();
        $result = $this->db->get_where($this->table, $where);
        $this->db->flush_cache();
        $count = $result->num_rows();
        $this->reset_connection();
        return $count;
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

        $this->reset_connection();
        return true;
    }

    public function is_existed($phone, $email=null) {
        $this->init_connection();
        if (is_logged_in()) {
            $this->db->where("id != ", $_SESSION["uid"])
                ->group_start()
                ->where("phone", $phone)
                ->or_where("email", $email)
                ->group_end();
        } else {
            $this->db->where("phone", $phone);
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

    private function uploadImage() {
        $this->init_connection();
        $id = $_SESSION["uid"];
        $avatar = uploadImage("./resources/customers/".$id."/", "avatar-file");
        if ($avatar && $avatar != "") {
            $this->db->update($this->table, ["avatar" => $avatar], ["id" => $id]);
        }
        $this->reset_connection();
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

    public function update() {
        $this->init_connection();

        $id = $_SESSION["uid"];
		$phone = $this->input->post("phone");
        $email = $this->input->post("email");
        $name = $this->input->post("name");
		$gender = $this->input->post("gender");
		$birthday = $this->input->post("birthday");
		$address = $this->input->post("address");

        $new_data = [
            "phone"         => $phone,
            "email"         => $email,
            "name"          => $name,
            "gender"        => $gender,
            "birthday"      => $birthday,
            "address"       => $address
        ];

        $this->db->update($this->table, $new_data, ["id" => $id]);

        $this->uploadImage();

        $this->reset_connection();
        return true;
    }

    public function register_notification($user_id, $uid) {
        $this->init_connection();
        $new_data = ["notification_uid" => $uid];
        $this->db->update($this->table, $new_data, ["id" => $user_id]);
        $this->reset_connection();
        return true;
    }

    public function get_notification_uid($user_id) {
        $user = $this->get($user_id);
        return $user->notification_uid;
    }

}
