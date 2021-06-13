<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function hashing_password($password) {
    return hash("sha256", $password . HASHING_KEY);
}

function cms_is_logged_in() {
    return isset($_SESSION["cms_uid"]) && $_SESSION["cms_uid"] > 0;
}

function alert_message_box($message) {
    $_SESSION["alert_message"] = $message;
}

function raise_message_ok($message) {
    $_SESSION["message_ok"] = $message;
}

function raise_message_err($message) {
    $_SESSION["message_err"] = $message;
}

function uploadImage($path, $filename) {
    $CI = &get_instance();
    
    if (!is_dir($path)) {
        if (mkdir($path, DIR_WRITE_MODE, true)) {
            chmod($path, DIR_WRITE_MODE);
        }
    }

    $config = [
        'upload_path' => $path,
        'allowed_types' => "jpg|jpeg|jpg|png",
        'overwrite' => TRUE,
        'encrypt_name' => TRUE,
        'max_size' => "102400000"
    ];

    $CI->load->library('upload', $config);
    $CI->upload->initialize($config);

    if (!$CI->upload->do_upload($filename)) {
        return "";
    }
    else {
        $uploaded_file = $CI->upload->data();
        return $uploaded_file['file_name'];
    }
}

function gender_array() {
    return [
        "0" => "Other",
        "1" => "Male",
        "2" => "Female"
    ];
}

function in_role($role_array) {
    return in_array($_SESSION["cms_urole"], $role_array);
}

function is_logged_in() {
    return isset($_SESSION["uid"]) && $_SESSION["uid"] > 0;
}

function is_logged_seat() {
    return isset($_SESSION["ubranch"]) && $_SESSION["ubranch"] > 0
        && isset($_SESSION["utable"]) && $_SESSION["utable"] > 0;
}

function firstMonthDate($month=null) {
    if ($month == null) {
        $month_date = date('Y-m-01');
    } else {
        $month_date = date('Y-'.sprintf('%02d', $month).'-01');
    }
    return date('Y-m-01 00:00:00', strtotime($month_date));
}

function lastMonthDate($month=null) {
    if ($month == null) {
        $month_date = date('Y-m-01');
    } else {
        $month_date = date('Y-'.sprintf('%02d', $month).'-01');
    }
    return date('Y-m-t 23:59:59', strtotime($month_date));
}

function beginDate() {
    return date('Y-m-d 00:00:00');
}

function endDate() {
    return date('Y-m-d 23:59:59');
}

function deltaMonthFirstDate($delta) {
    return date('Y-m-01 00:00:00', strtotime("-$delta month"));
}

function deltaMonthLastDate($delta) {
    return date('Y-m-t 23:59:59', strtotime("-$delta month"));
}

function month_array() {
    return [
        "1" => "JAN",
        "2" => "FEB",
        "3" => "MAR",
        "4" => "APR",
        "5" => "MAY",
        "6" => "JUN",
        "7" => "JUL",
        "8" => "AUG",
        "9" => "SEP",
        "10" => "OCT",
        "11" => "NOV",
        "12" => "DEC",
    ];
}

function paginationConfigs($page, $per_page, $total, $url) {
    $config["base_url"] = str_replace("page=".$page, "", str_replace("&page=".$page, "", base_url($url.(($_SERVER["QUERY_STRING"] != "") ? "?".$_SERVER["QUERY_STRING"] : "?"))));
    $config["cur_page"] = $page;
    $config["per_page"] = $per_page;
    $config["num_links"] = 3;
    $config["use_page_numbers"] = true;
    $config["total_rows"] = $total;
  
    $config['full_tag_open'] = '<ul class="pagination pagination-md m-0 float-right">';
    $config['full_tag_close'] = '</ul>';
    $config['first_link'] = '<<';
    $config['last_link'] = '>>';
    $config['first_tag_open'] = '<li class="page-item">';
    $config['first_tag_close'] = '</li>';
    $config['first_tag_class'] = 'page-link';
    $config['last_tag_open'] = '<li class="page-item">';
    $config['last_tag_close'] = '</li>';
    $config['last_tag_class'] = 'page-link';
    $config['prev_link'] = '<';
    $config['prev_tag_open'] = '<li class="page-item">';
    $config['prev_tag_close'] = '</li>';
    $config['prev_tag_class'] = 'page-link';
    $config['next_link'] = '>';
    $config['next_tag_open'] = '<li class="page-item">';
    $config['next_tag_close'] = '</li>';
    $config['next_tag_class'] = 'page-link';
    $config['cur_tag_open'] = '<li class="page-item active"><a href="#" class="page-link">';
    $config['cur_tag_close'] = '</a></li>';
    $config['num_tag_open'] = '<li class="page-item">';
    $config['num_tag_close'] = '</li>';
    $config['num_tag_class'] = 'page-link';
    
    return $config;
}

function can_feedback($menu_id) {

    if (!is_logged_in()) return false;

    $CI = &get_instance();
    $CI->load->model('M_Customer');

    $can_feedback = $CI->M_Customer->can_feedback($_SESSION['uid'], $menu_id);

    return $can_feedback;
}