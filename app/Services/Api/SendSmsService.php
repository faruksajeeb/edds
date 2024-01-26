<?php

namespace App\Services\Api;

trait SendSmsService
{

    public function sendSms($mobileNo, $text)
    {
        return 'Manually Off';
        if ($mobileNo && $text) {
            try {
                $url = env('SMS_HOST');
                $api_key = env('SMS_API_KEY');
                $senderid = env('SMS_SENDER_ID');
                $data = [
                    "api_key" => $api_key,
                    "senderid" => $senderid,
                    "number" => $mobileNo,
                    "message" => $text
                ];

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $response = curl_exec($ch);
                curl_close($ch);
                return $response;
            } catch (\Exception $e) {
                return "SMS doesn\'t send. " . $e->getMessage();
            }
        }
    }
}
