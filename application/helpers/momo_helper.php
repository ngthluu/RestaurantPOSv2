<?php
defined('BASEPATH') OR exit('No direct script access allowed');

const END_POINT = "https://test-payment.momo.vn/gw_payment/transactionProcessor";

const PARTNER_CODE = "MOMOBKUN20180529";
const ACCESS_KEY = "klm05TvNBzhg7h7j";
const SECRET_KEY = "at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa";

const RETURN_URL = "checkout/payment_result";
const NOTIFY_URL = "checkout/payment_notify";

function execPostRequest($url, $data) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_CAINFO, APPPATH . 'libraries/cacert.pem');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data)
    ]);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

    $result = curl_exec($ch);
    if ($result === false) {
		throw new Exception(curl_error($ch), curl_errno($ch));
	}

    curl_close($ch);
    return $result;
}

function paymentMomo($order, $order_price) {

    $orderId = $order->order_code.".".time();
    $orderInfo = "Paid for order ".$order->order_code." at POS v2";
    $amount = strval($order_price);
    $requestId = time()."";
    $extraData = "";

    $rawHash = "partnerCode=".PARTNER_CODE
        ."&accessKey=".ACCESS_KEY
        ."&requestId=".$requestId
        ."&amount=".$amount
        ."&orderId=".$orderId
        ."&orderInfo=".$orderInfo
        ."&returnUrl=".site_url(RETURN_URL)
        ."&notifyUrl=".site_url(NOTIFY_URL)
        ."&extraData=".$extraData;

    $signature = hash_hmac("sha256", $rawHash, SECRET_KEY);

    $data = [
        'partnerCode' => PARTNER_CODE,
        'accessKey' => ACCESS_KEY,
        'requestId' => $requestId,
        'amount' => $amount,
        'orderId' => $orderId,
        'orderInfo' => $orderInfo,
        'returnUrl' => site_url(RETURN_URL),
        'notifyUrl' => site_url(NOTIFY_URL),
        'extraData' => $extraData,
        'requestType' => 'captureMoMoWallet',
        'signature' => $signature
    ];

    $result = execPostRequest(END_POINT, json_encode($data));
    $jsonResult = json_decode($result, true);

    return $jsonResult["payUrl"];
}

function paymentMomoCheckResult($data) {
    $partnerCode = $data["partnerCode"];
    $accessKey = $data["accessKey"];
    $orderId = $data["orderId"];
    $localMessage = $data["localMessage"];
    $message = $data["message"];
    $transId = $data["transId"];
    $orderInfo = $data["orderInfo"];
    $amount = $data["amount"];
    $errorCode = $data["errorCode"];
    $responseTime = $data["responseTime"];
    $requestId = $data["requestId"];
    $extraData = $data["extraData"];
    $payType = $data["payType"];
    $orderType = $data["orderType"];
    $extraData = $data["extraData"];
    $m2signature = $data["signature"];

    $rawHash = "partnerCode=".$partnerCode
        . "&accessKey=" . $accessKey 
        . "&requestId=" . $requestId 
        . "&amount=" . $amount 
        . "&orderId=" . $orderId 
        . "&orderInfo=" . $orderInfo 
        . "&orderType=" . $orderType 
        . "&transId=" . $transId 
        . "&message=" . $message 
        . "&localMessage=" . $localMessage 
        . "&responseTime=" . $responseTime 
        . "&errorCode=" . $errorCode 
        . "&payType=" . $payType 
        . "&extraData=" . $extraData;
    
    $partnerSignature = hash_hmac("sha256", $rawHash, SECRET_KEY);
    if ($m2signature == $partnerSignature) {
        if ($errorCode == '0') {
            return "ok";
        }
        return $message;
    }

    return "failed";
}