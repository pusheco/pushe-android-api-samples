<?php



$TOKEN = "YOUR_TOKEN";

// Webpush -> https://pushe.co/docs/webpush-api/

$data = array(
    "app_ids" => ["YOUR_APPLICATION_ID"],
    "platform" => 2,
    "data" => array(
        "title" => "This is a simple push with icon",
        "content" => "All of your users will see me",
        "icon" => "http://static.pushe.co/emails/images/logo.png",
        "image" => "http://static.pushe.co/emails/images/logo.png"
    ),
    // additional keywords -> https://pushe.co/docs/webpush-api/#api_advance_notification_table1
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
