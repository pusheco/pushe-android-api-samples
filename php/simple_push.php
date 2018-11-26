<?php

$TOKEN = "YOUR_TOKEN";

$data = array(
    "app_ids" => ["YOUR_APPLICATION_ID"],
    "data" => array(
        "title" => "this is the title",
        "content" => "this is the content",
    ),
);
$data_string = json_encode($data);

$ch = curl_init("https://api.pushe.co/v2/messaging/notifications/");
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Content-Type: application/json",
    "Accept: application/json",
    "Authorization: Token " . $TOKEN,
));

curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$reponse = curl_exec($ch);
$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "status code => $status_code\n";
echo "response => $reponse"

?>
