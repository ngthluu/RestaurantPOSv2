<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Menu extends CI_Model {

    public const STATUS_NOT_PUBLISHED = 0;
    public const STATUS_PUBLISHED = 1;

    public const STATUS_DATE_NOT_AVAILABLE = 0;
    public const STATUS_DATE_AVAILABLE = 1;

    private function init_connection() {
        $this->table = $this->db->dbprefix("menu");
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

    public function gets_all_statistics($where=null) {
        $this->init_connection();
        $this->db->reset_query();
        
        $this->db->select("*");
        $this->db->select("menu.id AS menu_id");
        $this->db->select("SUM(quantity) AS sum");
        $this->db->from($this->db->dbprefix("menu"));
        $this->db->join($this->db->dbprefix("orderdetails"), 'orderdetails.menu = menu.id');
        $this->db->join($this->db->dbprefix("orders"), 'orders.id = orderdetails.order');
        $this->db->group_by("menu.id");
        $this->db->order_by("sum", "DESC");
        $this->db->where($where);
        $result = $this->db->get();

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

    private function uploadImage($id) {
        $this->init_connection();
        $image = uploadImage("./resources/menu/".$id."/", "image-file");
        if ($image && $image != "") {
            $this->db->update($this->table, ["image" => $image], ["id" => $id]);
        }
        $this->reset_connection();
    } 

    public function add() {

        $this->init_connection();

        $name = $this->input->post("name");
		$branch = $this->input->post("branch");
        $description = $this->input->post("description");
        $price = $this->input->post("price");

        $new_data = [
            "name"          => $name,
            "branch"        => $branch,
            "description"   => $description,
            "price"         => $price,
            "status"        => self::STATUS_NOT_PUBLISHED,
            "status_date"   => self::STATUS_DATE_NOT_AVAILABLE
        ];
        $this->db->insert($this->table, $new_data);
        
        $id = $this->db->insert_id();

        $this->uploadImage($id);

        $this->reset_connection();
        return $id;
    }

    public function update($id) {

        $this->init_connection();

        $name = $this->input->post("name");
		$branch = $this->input->post("branch");
        $description = $this->input->post("description");
        $price = $this->input->post("price");

        $new_data = [
            "name"          => $name,
            "branch"        => $branch,
            "description"   => $description,
            "price"         => $price
        ];

        $this->db->update($this->table, $new_data, ["id" => $id]);

        $this->uploadImage($id);

        $this->reset_connection();
        return true;
    }

    public function change_status($id) {
        $this->init_connection();
        $menu = $this->get($id);
        if ($menu->status == self::STATUS_NOT_PUBLISHED) {
            $this->db->update($this->table, ["status" => self::STATUS_PUBLISHED], ["id" => $id]);
        } else if ($menu->status == self::STATUS_PUBLISHED) {
            $this->db->update($this->table, ["status" => self::STATUS_NOT_PUBLISHED], ["id" => $id]);
        }

        $this->reset_connection();
        return true;
    }

    public function change_status_date($id) {
        $this->init_connection();
        $menu = $this->get($id);
        if ($menu->status_date == self::STATUS_DATE_NOT_AVAILABLE) {
            $this->db->update($this->table, ["status_date" => self::STATUS_DATE_AVAILABLE], ["id" => $id]);
        } else if ($menu->status == self::STATUS_DATE_AVAILABLE) {
            $this->db->update($this->table, ["status_date" => self::STATUS_DATE_NOT_AVAILABLE], ["id" => $id]);
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
