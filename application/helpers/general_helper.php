<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function hashing_password($password) {
    return hash("sha256", $password . HASHING_KEY);
}

function cms_is_logged_in() {
    return isset($_SESSION["cms_uid"]) && $_SESSION["cms_uid"] > 0;
}

function alert_message_box($message) {
    $_SESSION["cms_alert_message"] = $message;
}

function raise_message_ok($message) {
    $_SESSION["cms_message_ok"] = $message;
}

function raise_message_err($message) {
    $_SESSION["cms_message_err"] = $message;
}

function uploadImage($path, $filename) {
    $CI = &get_instance();
    
    if (!is_dir($path)) {
        if (mkdir($path, DIR_WRITE_MODE, true)) {
            chmod($path, DIR_WRITE_MODE);
        }
    }

    $config = array(
        'upload_path' => $path,
        'allowed_types' => "jpg|jpeg|jpg|png",
        'overwrite' => TRUE,
        'encrypt_name' => TRUE,
        'max_size' => "102400000"
    );

    $CI->load->library('upload', $config);
    $CI->upload->initialize($config);

    if (!$CI->upload->do_upload($filename)) {
        return false;
    }
    else {
        $uploaded_file = $CI->upload->data();
        return $uploaded_file['file_name'];
    }
}

function gender_array() {
    return array(
        "0" => "Other",
        "1" => "Male",
        "2" => "Female"
    );
}