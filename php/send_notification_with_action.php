<?php

// Android doc -> http://docs.pushe.co/docs/mobile-api/notification-actions/
// Obtain token -> http://docs.pushe.co/docs/mobile-api/authentication/
$TOKEN = "YOUR_TOKEN";

$data = array(
    "app_ids" => ["YOUR_APP_ID"],
    "data" => array(
        "title" => "This is a notification with buttons",
        "content" => "In this notification, every button has an action.",
        "action" => array(
            "url" => "",
            "action_type" => "A"
        ),
        "buttons"=> array(
            array(
                "btn_content"=> "Open App",
                "btn_action"=> array("action_type"=> "A"),
                "btn_order"=> 0),
            ),
            array(
                "btn_content"=> "Call",
                "btn_action"=> array(
                    "action_type"=> "U",
                    "url"=> "tel:02187654321"
                ),
                "btn_order"=> 1
            ),
            array(
                "btn_content"=> "Install App",
                "btn_action"=> array(
                    "action_type"=> "U",
                    "params"=> array("market"=> "bazaar", "package_name"=> "shop.barkat.app"),
                    "url"=> "bazaar://details?id=shop.barkat.app",
                    "market_package_name"=> "com.farsitel.bazaar"
                ),
                "btn_icon"=> "add_box",
                "btn_order"=> 2
            )
        )
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
