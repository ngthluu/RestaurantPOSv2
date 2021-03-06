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

    public function gets_price($where=null) {
        $this->init_connection();
        $this->db->reset_query();

        $this->db->select("*");
        $this->db->from($this->db->dbprefix("orderdetails"));
        $this->db->join($this->db->dbprefix("menu"), 'menu.id = orderdetails.menu');
        $this->db->join($this->db->dbprefix("orders"), 'orders.id = orderdetails.order');
        $this->db->where($where);
        $result = $this->db->get();
        $price = 0;
        foreach ($result->result() as $item) {
            $price += $item->price * $item->quantity;
        }
        return $price;
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

    public function get_with_code($order_code, $where=null) {
        $this->init_connection();
        $w = ["order_code" => $order_code];
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
        $this->load->helper("onesignal_helper");
        $this->load->model("M_Customer");
        $order = $this->get($id);
        if ($order->status == self::STATUS_PAYMENT_OK) {
            $notification_uid = $this->M_Customer->get_notification_uid($order->customer);
            sendMessage([$notification_uid], [
                "status" => "ok",
                "message" => "Your order $order->order_code has been received"
            ]);
            $this->db->update($this->table, ["status" => self::STATUS_RECEIVED], ["id" => $id]);
        } else if ($order->status == self::STATUS_RECEIVED) {
            $notification_uid = $this->M_Customer->get_notification_uid($order->customer);
            sendMessage([$notification_uid], [
                "status" => "ok",
                "message" => "Your order $order->order_code is in processing now"
            ]);
            $this->db->update($this->table, ["status" => self::STATUS_IN_PROCESS], ["id" => $id]);
        
        } else if ($order->status == self::STATUS_IN_PROCESS) {
            
            // Notify to customers
            $notification_uid = $this->M_Customer->get_notification_uid($order->customer);
            sendMessage([$notification_uid], [
                "status" => "ok",
                "message" => "Your order $order->order_code has been finished. It will be served immediately."
            ]);

            // Notify to waiters
            $this->load->model("M_Staff");
            $uids = $this->M_Staff->get_notification_uids(["role" => "waiter", "branch" => $order->branch]);
            sendMessage($uids, [
                "status" => "ok",
                "message" => "Order $order->order_code is ready to serve at table #$order->table."
            ]);

            $this->db->update($this->table, ["status" => self::STATUS_FINISHED], ["id" => $id]);
        }

        $this->reset_connection();
        return true;
    }

    public function cancel($id) {
        $this->init_connection();
        
        $this->db->update($this->table, ["status" => self::STATUS_PAYMENT_FAILED], ["id" => $id]);

        $this->reset_connection();
        return true;
    }

    public function paid($id) {
        $this->init_connection();
        
        $this->db->update($this->table, ["status" => self::STATUS_PAYMENT_OK], ["id" => $id]);

        $this->reset_connection();
        return true;
    }

    private function generate_code() {
        
        $this->init_connection();
        
        $order_code = "ORDER".date("dmy").$_SESSION["uid"];
        $order_code_like_count = $this->db->like('order_code', $order_code, 'after')->get($this->table);
        $this->db->flush_cache();
        $order_code_like_count = $order_code_like_count->num_rows();
        $order_code .= sprintf('%03d', $order_code_like_count + 1);

        $this->reset_connection();
        
        return $order_code;
    }

    public function save() {

        $this->init_connection();

        $new_data = [
            "order_code"    => $this->generate_code(),
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
