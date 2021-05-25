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