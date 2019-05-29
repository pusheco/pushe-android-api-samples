<?php
/*
 * hashed_id just generated for Non-Free plan
 */
$TOKEN = "YOUR_TOKEN";

$data = array(
    "app_ids" => ["APP_ID_1",],
    "platform" => 1, // optional for android
    "data" => array(
        "title" => "this is the title", // (compulsive)
        "content" => "this is the content", // (compulsive)
    ),
);

// initialize curl
$ch = curl_init("https://api.pushe.co/v2/messaging/notifications/");

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
$hashed_id = json_decode($response)->hashed_id;

print_r($hashed_id);

curl_close($ch);
?>
