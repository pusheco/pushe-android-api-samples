<?php

// Android doc -> http://docs.pushe.co/docs/mobile-api/custom-content-notification/
// Obtain token -> http://docs.pushe.co/docs/mobile-api/authentication/
$TOKEN = "YOUR_TOKEN";

$data = array(
    "app_ids" => ["YOUR_APP_ID",],
    "custom_content" => array(
        'key1' => 'value1',
        'key2' => 'value2'
    ),
);

// initialize curl
$ch = curl_init("https://api.pushe.co/v2/messaging/notifications/");
// In order to send a notification to iOS applications use this url
// https://api.pushe.co/v2/messaging/notifications/ios

// set header parameters
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Content-Type: application/json",
    "Accept: application/json",
    "Authorization: Token " . $TOKEN,
));
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// set data
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$response = curl_exec($ch);

// report url only generated on Non-Free plan
$hashed_id = json_decode($response)->hashed_id;

print_r($hashed_id);

curl_close($ch);
?>
