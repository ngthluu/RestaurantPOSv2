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