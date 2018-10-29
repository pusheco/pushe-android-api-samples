<?php

$TOKEN = "YOUR_TOKEN";

$data = array(
  "applications" => ["YOUR_APPLICATION_ID", ],
  "notification" => array(
    "action" => array(
      "action_type" => "T",
      "url" => "",
    ),
    "action_data" => "SettingsActivity",
    "title" => "this is the title",
    "content" => "this is the content",
  )
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
