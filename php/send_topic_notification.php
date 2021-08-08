<?php

// Android doc -> http://docs.pushe.co/docs/mobile-api/topic-notification/
// Obtain token -> http://docs.pushe.co/docs/mobile-api/authentication/
$TOKEN = "YOUR_TOKEN";

$data = array(
    "app_ids" => ["YOUR_APP_ID"],
    "data" => array(
        "title" => "This is a topic notification",
        "content" => "Only users already subscribed to topic can see me",
    ),
    "topics" => => array("TOPIC_1","TOPIC_2")
);

$ch = curl_init("https://api.pushe.co/v2/messaging/notifications/");
// In order to send a notification to iOS applications use this url
// https://api.pushe.co/v2/messaging/notifications/ios

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

if ($status_code == 201) {
    echo "Success!\n";

    $reponse_json = json_decode($reponse);

    if ($reponse_json->hashed_id) {
        $report_url = "https://pushe.co/report?id=$reponse_json->hashed_id";
    } else {
        $report_url = "no report url for your plan";
    }
    echo "report_url: $report_url\n";

    echo "notification id: $reponse_json->wrapper_id\n";
} else {
    echo "failed!\n";
}
