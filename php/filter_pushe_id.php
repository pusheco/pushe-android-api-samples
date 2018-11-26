<?php

$TOKEN = "YOUR_TOKEN";

$data = array(
    "app_ids" => ["YOUR_APPLICATION_ID"],
    "data" => array(
        "title" => "This push is filtered by pushe_id",
        "content" => "Only choosen users can see me",
    ),
    "filters" => array(
        "pushe_id" => ["DEVICE_PUSHE_ID"],
    ),
);

$ch = curl_init("https://api.pushe.co/v2/messaging/notifications/");

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

    // notification created
    $reponse_json = json_decode($reponse);

    if ($reponse_json->hashed_id) {
        $report_url = "https://pushe.co/report?id=$reponse_json->hashed_id";
    } else {
        $report_url = "no report url for free plan";
    }
    echo "report_url: $report_url\n";

    echo "notification id: $reponse_json->wrapper_id\n";
} else {
    // creating notification failed
    echo "failed!\n";
}

?>
