<?php
defined('BASEPATH') OR exit('No direct script access allowed');

const ONESIGNAL_ENDPOINT = "https://onesignal.com/api/v1/notifications";
const ONESIGNAL_APP_ID = "f8f03c9f-5aff-482d-8e2f-1b54a0ea5b68";
const ONESIGNAL_REST_API_KEY = "MjFhMzk2ODMtYTZiMi00NDljLTk5YTktMDEwZmQ1ZDA1Yzgy";

function sendMessageToCustomer($content) {
    $content = array("en" => $content);
    $fields = array(
        'app_id' => ONESIGNAL_APP_ID,
        'included_segments' => array('Active Users'),
        'data' => array("foo" => "bar"),
        'contents' => $content,
        'web_buttons' => []
    );
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, ONESIGNAL_ENDPOINT);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json; charset=utf-8',
        'Authorization: Basic '.ONESIGNAL_REST_API_KEY
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    return $response;
}
