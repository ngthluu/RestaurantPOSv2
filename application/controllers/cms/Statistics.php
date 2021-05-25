<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Statistics extends CMS_Controllers {

	public function __construct() {
		parent::__construct();
	}

	public function revenue() {

		if (!in_role(["admin", "manager"])) {
			redirect(site_url("cms/dashboard"));
			return;
		}  

		$data["header_title"] = "Revenue";
		$data["breadcrumb_list"] = [
			["uri" => site_url("cms/dashboard"), "title" => "Home"],
			["uri" => "#", "title" => "Revenue"],
		];

		$data["main_view"] = "cms/statistics/revenue";

		// Sales rate
		$this->load->model("M_Order");
		$orders_count_this_month = $this->M_Order->gets_count([
			"status != " => M_Order::STATUS_INIT,
			"status <> " => M_Order::STATUS_PAYMENT_FAILED,
			"order_time >= " => firstMonthDate(),
			"order_time <= " => lastMonthDate()
		]);
		$orders_count_last_month = $this->M_Order->gets_count([
			"status != " => M_Order::STATUS_INIT,
			"status <> " => M_Order::STATUS_PAYMENT_FAILED,
			"order_time >= " => deltaMonthFirstDate(1),
			"order_time <= " => deltaMonthLastDate(1)
		]);
		$data["sales_rate"] = $orders_count_last_month != 0 ? ($orders_count_this_month - $orders_count_last_month) / $orders_count_last_month : $orders_count_this_month;
		$data["sales_rate"] *= 100;

		// Customers rate
		$this->load->model("M_Customer");
		$customers_count_this_month = $this->M_Customer->gets_count([
			"create_time >= " => firstMonthDate(),
			"create_time <= " => lastMonthDate()
		]);
		$customers_count_last_month = $this->M_Customer->gets_count([
			"create_time >= " => deltaMonthFirstDate(1),
			"create_time <= " => deltaMonthLastDate(1)
		]);
		$data["customers_rate"] = $customers_count_last_month != 0 ? ($customers_count_this_month - $customers_count_last_month) / $customers_count_last_month : $customers_count_this_month;
		$data["customers_rate"] *= 100;
		
		// Chart data
		$data["chart_data_this_year"] = [];
		$data["chart_title"] = [];
		$chart_data_total_this_month = $this->M_Order->gets_price([
			"order_time >= " => firstMonthDate(),
			"order_time <= " => lastMonthDate(),
			"orders.status != " => M_Order::STATUS_INIT,
			"orders.status <> " => M_Order::STATUS_PAYMENT_FAILED
		]);
		$chart_data_total_last_month = $this->M_Order->gets_price([
			"order_time >= " => deltaMonthFirstDate(1),
			"order_time <= " => deltaMonthLastDate(1),
			"orders.status != " => M_Order::STATUS_INIT,
			"orders.status <> " => M_Order::STATUS_PAYMENT_FAILED
		]);
		$data["total_rate"] = $chart_data_total_last_month != 0 ? ($chart_data_total_this_month - $chart_data_total_last_month) / $chart_data_total_last_month : $chart_data_total_this_month;
		$data["total_rate"] *= 100;
		$data["chart_data_total_this_month"] = $chart_data_total_this_month;
		foreach (month_array() as $index => $text) {
			array_push($data["chart_title"], $text);
			$total_revenue_month = $this->M_Order->gets_price([
				"order_time >= " => firstMonthDate($index),
				"order_time <= " => lastMonthDate($index),
				"orders.status != " => M_Order::STATUS_INIT,
				"orders.status <> " => M_Order::STATUS_PAYMENT_FAILED
			]);
			array_push($data["chart_data_this_year"], $total_revenue_month);
		}
		
		// Menu list
		$this->load->model("M_Menu");
		$data["menu_list"] = $this->M_Menu->gets_all_statistics();
		
		$this->load->view("cms/layout/main", $data);
	}

	public function salary() {

		$data["header_title"] = "Staffs salary";
		$data["breadcrumb_list"] = [
			["uri" => site_url("cms/dashboard"), "title" => "Home"],
			["uri" => "#", "title" => "Salary"],
		];

        $this->load->model("M_Staff");
        $this->load->model("M_Branch");

		if (in_role(["manager"])) {
			$data["staffs_list"] = $this->M_Staff->gets_all(["branch" => $_SESSION["cms_ubranch"]]);
		} else if (!in_role(["admin"])) {
			$data["staffs_list"] = $this->M_Staff->gets_all(["id" => $_SESSION["cms_uid"]]);
		} else {
			$data["staffs_list"] = $this->M_Staff->gets_all();
		}

		$data["main_view"] = "cms/statistics/salary";

		$this->load->view("cms/layout/main", $data);
	}
	
}
