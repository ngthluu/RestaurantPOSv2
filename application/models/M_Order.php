<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_Order extends CI_Model {

    public const STATUS_INIT = 0;
    public const STATUS_PAYMENT_OK = 1;
    public const STATUS_PAYMENT_FAILED = 2;
    public const STATUS_RECEIVED = 3;
    public const STATUS_IN_PROCESS = 4;
    public const STATUS_FINISHED = 5;

    private function init_connection() {
        $this->table = $this->db->dbprefix("orders");
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
        $menu = $this->get($id);
        if ($menu->status == self::STATUS_PAYMENT_OK) {
            $this->db->update($this->table, ["status" => self::STATUS_RECEIVED], ["id" => $id]);
        } else if ($menu->status == self::STATUS_RECEIVED) {
            $this->db->update($this->table, ["status" => self::STATUS_IN_PROCESS], ["id" => $id]);
        } else if ($menu->status == self::STATUS_IN_PROCESS) {
            $this->db->update($this->table, ["status" => self::STATUS_FINISHED], ["id" => $id]);
        }

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

    public function save() {

        $this->init_connection();

        $order_code = "ORDER".date("dmy").sprintf('%03d', $this->get_count() + 1);

        $new_data = [
            "order_code"    => $order_code,
            "customer"      => $_SESSION["uid"],
            "branch"        => $_SESSION["cart"]->branch,
            "table"         => $_SESSION["cart"]->table,
            "note"          => $_SESSION["cart"]->note,
            "status"        => self::STATUS_INIT,
        ];
        $this->db->insert($this->table, $new_data);
        $id = $this->db->insert_id();

        // Order details
        foreach ($_SESSION["cart"]->details as $detail) {
            $this->db->insert($this->db->dbprefix("orderdetails"), [
                "order" => $id,
                "menu" => $detail->id,
                "quantity" => $detail->quantity
            ]);
        }

        $this->reset_connection();
        return $id;
    }

    public function get_price($id) {
        $order_details = $this->get_details($id);
        $price = 0;
        foreach ($order_details as $item) {
            $price += $item->price * $item->quantity;
        }
        return $price;
    }

    public function get_details($id) {
        $this->init_connection();
        $this->db->reset_query();

        $this->db->select("*");
        $this->db->from($this->db->dbprefix("orderdetails"));
        $this->db->join($this->db->dbprefix("menu"), 'menu.id = orderdetails.menu');
        $this->db->where(["order" => $id]);

        $result = $this->db->get();
        $this->db->flush_cache();
        if ($result->num_rows() == 0) {
            $this->reset_connection();
            return [];
        }
        $this->reset_connection();
        return $result->result();
    }
}
