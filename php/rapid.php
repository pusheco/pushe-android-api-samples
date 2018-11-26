<?php

$TOKEN = "YOUR_TOKEN";

$data = array(
    "app_id" => "YOUR_APPLICATION_ID",
    "data" => array(
        "title" => "This is a rapid push",
        "content" => "go go go!",
    ),
    "pids" => ["DEVICE_PUSHE_ID"],
);

$ch = curl_init("https://api.pushe.co/v2/messaging/rapid/");

curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Content-Type: application/json",
    "Accept: application/json",
    "Authorization: Token " . $TOKEN,
));

curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$reponse = curl_exec($ch);
$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "status code => $status_code\n";
echo "response => $reponse\n";
echo "==========\n";

if ($status_code == 200) {
    echo "Success!\n";
} else {
    // creating notification failed
    echo "failed!\n";
}
