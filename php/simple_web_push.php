<?php

$TOKEN = "YOUR_TOKEN";

$data = array(
  "applications" => ["YOUR_APPLICATION_ID", ],
  "notification" => array(
    "title" => "this is the title",
    "content" => "this is the content",
    "visibility" => true,
    "show_app" => true,
    // these are other fiels (ALL ARE OPTIONAL)
    // "url" => "http://google.com", // set this link to open another url when user clicks on notification
    // "icon" => "http://link_to_image.png",
    // "image" => "http://link_to_image.png",
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
