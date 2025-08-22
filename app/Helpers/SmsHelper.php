<?php

use Illuminate\Support\Facades\Log;

if (!function_exists('sendSMS')) {
    function sendSMS($mobile, $otp)
    {
        $url = "http://bulksmsbd.net/api/smsapi";
        $api_key = "1Hw8pwukRk2GTiulZvnP";
        $senderid = '8809617622283';

        $message = "Your OTP code is: $otp\nVerify your identity.\nThank you.";


        $data = [
            "api_key"  => $api_key,
            "senderid" => $senderid,
            "number"   => $mobile,
            "type"     => "text",
            "message"  => $message
        ];

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($ch);
            curl_close($ch);

            Log::info("SMS sent to $mobile | OTP: $otp | Response: $response");
            return $response;
        } catch (\Exception $e) {
            Log::error("SMS failed to $mobile: " . $e->getMessage());
            return false;
        }
    }

}
