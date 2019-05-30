<?php

$TOKEN = "YOUR_TOKEN";

// Android -> https://pushe.co/docs/api/

$data = array(
    "app_ids" => ["APP_ID_1",],
    "data" => array(
        "title" => "this is the title",
        "content" => "this is the content",

        //actions -> https://pushe.co/docs/api/#api_action_type_table3
        "action" => array(
            "action_type" => "U",
            "url" => "myket://application/#Intent;scheme=myket;package=package_name",
        ),

        "buttons" => array(
            array(
                "btn_action" => array(
                    "action_data" => "ActivityName",
                    "action_type" => "T",
                    "market_package_name" => "",
                    "url" => "",
                ),
                "btn_content" => "content",
                // icons -> https://pushe.co/docs/api/#api_icon_notificaiton_table2
                "btn_icon" => "open_in_browser",
                "btn_order" => 0,
            )
        ),
    ),
    // additional keywords -> https://pushe.co/docs/api/#api_send_advance_notification
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

// set data
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$response = curl_exec($ch);

echo "response \n";
print_r($response);


?>
