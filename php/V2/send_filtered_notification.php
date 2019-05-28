<?php

/* this notification will be sent to only 2 users
 * 1. user with imei=1234567890123456
 * 2. user with pushe_id=pid_20aa-ba40-a0
 */

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

$TOKEN = "2746e8cf5ebe571670166ed84621a5c15b13bb2a";
// Documentation: https://pushe.co/docs/api/#api_send_push_notification_to_single_users


// ******************************************************
// ***************** filtered with imei *****************
// ********************* For Android ********************
// ******************************************************
$imei_filtered_data = array(
    "app_ids" => ["APP_ID_1",],
    "platform" => 1, // optional for android
    "data" => array(
        "title" => "this is the title",
        "content" => "this is the content",
        // extra parameters on Documentation
    ),
    // filters with imei
    "filter" => array(
        "imei" => [
            "12**********56", // something like this
            "pid_**********", // something like this
        ],
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
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($imei_filtered_data));

$imei_response = curl_exec($ch);

echo "imei_response \n";
print_r($imei_response);

// ******************************************************
// **************** filtered with pushe_id **************
// ********************* For Android ********************
// ******************************************************
$pushe_id_filtered_data = array(
    "app_ids" => ["APP_ID_1",],
    "platform" => 1, // optional for android
    "data" => array(
        "title" => "this is the title",
        "content" => "this is the content",
        // extra parameters on Documentation
    ),
    // filters with imei
    "filter" => array(
        "pushe_id" => [
            "pid_************", // something like this
        ],
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
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($pushe_id_filtered_data));

$pushe_id_response = curl_exec($ch);

echo "pushe_id_response \n";
print_r($pushe_id_response);

// ******************************************************
// *************** filtered with device_id **************
// **************For Android and Web ********************
// ******************************************************
$pushe_id_filtered_data = array(
    "app_ids" => ["APP_ID_1",], // a list of app_ids
    "platform" => 1, // for android
    // platform => 2 // for web
    "data" => array(
        "title" => "this is the title",
        "content" => "this is the content",
        // extra parameters on Documentation
    ),
    // filters with imei
    "filter" => array(
        "device_id" => [
            "DEVICE_ID_1", // something like this
        ], // a list of device_id
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
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($pushe_id_filtered_data));

$device_id_response = curl_exec($ch);

echo "device_id_response \n";
print_r($device_id_response);


?>
