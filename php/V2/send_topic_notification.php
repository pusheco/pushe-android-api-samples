<?php

// obtain token -> https://pushe.co/docs/api/#api_get_token
$TOKEN = "YOUR_TOKEN";

// ***************************************************
// ************ Only for Android *********************
// ***************************************************
$data = array(
    "app_ids" => ["YOUR_APP_1",],
    "platform" => 1, // optional for android
    "data" => array(
        "title" => "this is the title", // (compulsive)
        "content" => "this is the content", // (compulsive)
    ),

    // not supported in web
    "topics" => array(
        "Topic1",
        "Topic2",
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
