<?php

/* get user pushe_id with this function in your application:
    ** Android **
  // java code //
  String pid = Pushe.getPusheId(this);
*/

/* get user device_id with this function in your website:
    ** Website **
    See:  https://pushe.co/docs/webpush/#unique_id

    Pushe.getDeviceId()
        .then((deviceId) => {
            console.log(`deviceId is: ${deviceId}`);
        });
*/

// obtain token -> https://pushe.co/docs/api/#api_get_token
$TOKEN = "YOUR_TOKEN";

$data = array(
    "app_ids" => ["YOUR_APP_1",],
    "platform" => 1, // optional for android
    // "platform" => 2 // for web
    "data" => array(
        // extra parameters on Documentation
        // https://pushe.co/docs/api/#api_advance_notification_table1

        "title" => "this is the title", // (compulsive)
        "content" => "this is the content", // (compulsive)

        // for webpush we just support open link action
        // See web doc: https://pushe.co/docs/webpush-api/#webpush_api_action_type_table2

        // notification action
        // open app in market
        "action" => array(
            "action_type" => "U",
            "url" => "myket://application/#Intent;scheme=myket;package=package_name",
        ),
        // more actions -> https://pushe.co/docs/api/#api_action_type_table3

        // notification buttons
        "buttons" => array(
            array(
                // open activity action
                // more actions -> https://pushe.co/docs/api/#api_action_type_table3
                "btn_action" => array(
                    "action_data" => "ActivityName",
                    "action_type" => "T",
                    "market_package_name" => "",
                    "url" => "",
                ),
                "btn_content" => "content",
                // "btn_icon"  only support in Android
                "btn_icon" => "open_in_browser", // icons -> https://pushe.co/docs/api/#api_icon_notificaiton_table2
                "btn_order" => 0,
            )
        ),
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

// set data
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$response = curl_exec($ch);

echo "response \n";
print_r($response);


?>
