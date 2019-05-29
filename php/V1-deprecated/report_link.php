<?php

$TOKEN = "YOUR_TOKEN";

/* send notification */
$data = array(
  "applications" => ["YOUR_APPLICATION_ID", ],
  "notification" => array(
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
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
$output = curl_exec($ch);
curl_close($ch);

/* response contains an id which is the identifier for current notification */
$output = json_decode($output);
$notif_id = $output->id;
echo "notification id is: $notif_id\n";

/* use $notif_id to generate report url for given notification */
$ch = curl_init("https://panel.pushe.co/api/v1/notifications/$notif_id/report_url/");
curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
  "Content-Type: application/json",
  "Accept: application/json",
  "Authorization: Token " . $TOKEN,
));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$output = curl_exec($ch);
$output = json_decode($output);
$report_url = $output->report_url;

echo "report url is: $report_url\n";
?>
