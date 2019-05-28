<?php

$TOKEN = "2746e8cf5ebe571670166ed84621a5c15b13bb2a";

$data = array(
    "app_ids" => ["co.pushe.apushe163test",],
    "platform" => 1, // optional for android
    // "platform" => 2, // for web
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

print_r($response);

curl_close($ch);
?>
