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

    public function gets_all($where=null, $page=1, $per_page=10) {
        $this->init_connection();
        $this->db->limit($per_page, ($page-1) * $per_page);
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

    public function get_rating_point($id) {
        $defaultRatings = 0;
        $this->init_connection();
        $this->db->select('AVG(rating) AS avg');
        $this->db->where(['menu' => $id]);
        $query = $this->db->get($this->db->dbprefix('menuratings'));
        $this->db->flush_cache();
        if ($query->num_rows() == 0) {
            $this->reset_connection();
            return $defaultRatings;
        }
        $this->reset_connection();
        return $query->row()->avg ? $query->row()->avg : $defaultRatings;
    }

    public function get_feedbacks($id, $page=1, $per_page=5) {
        $this->init_connection();

        $this->db->limit($per_page, ($page-1) * $per_page);
        $this->db->select("menuratings.*");
        $this->db->select("customers.id AS customer_id");
        $this->db->select("customers.name AS customer_name");
        $this->db->select("customers.avatar AS customer_avatar");
        $this->db->from($this->db->dbprefix("menuratings"));
        $this->db->join($this->db->dbprefix("customers"), 'customers.id = menuratings.customer');
        $this->db->where(["menu" => $id]);
        
        $result = $this->db->get();
        
        $this->db->flush_cache();
        if ($result->num_rows() == 0) {
            $this->reset_connection();
            return [];
        }
        $this->reset_connection();
        return $result->result();
    }

    public function get_feedbacks_count($id) {
        $this->init_connection();

        $this->db->from($this->db->dbprefix("menuratings"));
        $this->db->where(["menu" => $id]);
        
        $result = $this->db->get();
        $this->db->flush_cache();
        $this->reset_connection();

        return $result->num_rows();
    }

    public function save_feedback($menu_id) {
        $this->init_connection();

        $customer = $this->input->post("customer");
        $rating = $this->input->post("rating");
        $comment = htmlentities($this->input->post("comment"));

        $new_data = [
            "menu" => $menu_id,
            "customer" => $customer,
            "rating" => $rating,
            "comment" => $comment,
            "comment_time" => date('Y-m-d H:i:s')
        ];
        $this->db->insert($this->db->dbprefix('menuratings'), $new_data);
        $id = $this->db->insert_id();

        $this->reset_connection();
        return $id;
    }
}
