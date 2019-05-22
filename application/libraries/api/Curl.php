<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Curl
{
    public function action($url, $send_data, $header = null, $timeout = 10)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        if ($send_data) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $send_data);
        }

        if ($header) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }

        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);

        $response = curl_exec($ch); // 回傳 access_token
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_errno($ch);
        curl_close($ch);

        //print_r('Http:'.$httpCode.' err:'.$error.' res:'.$response);

        if ($error) {
            throw new Exception('系統繁忙中，請稍後再試', 10001);
        }
        return $response;
    }
}