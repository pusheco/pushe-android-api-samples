<?php

/* this notification will be sent to only 2 users
 * 1. user with imei=1234567890123456
 * 2. user with pushe_id=pid_20aa-ba40-a0
 */

/* get user pushe_id with this function in your application:

  // java code //
  String pid = Pushe.getPusheId(this);
*/

$TOKEN = "YOUR_TOKEN";

$data = array(
  "applications" => ["YOUR_APPLICATION_ID", ],
  "notification" => array(
    "title" => "this is the title",
    "content" => "this is the content",
  ),
  "filter" => array(
    "imei" => [
      "1234567890123456",
      "pid_20aa-ba40-a0",
    ],
  ),
);
$data_string = json_encode($data);

$ch = curl_init("http://panel.pushe.co/api/v1/notifications/");
curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
  "Content-Type: application/json",
  "Accept: application/json",
  "Authorization: Token " . $TOKEN,
));
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
$output = curl_exec($ch);
echo $output

?>
