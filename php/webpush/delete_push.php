<?php

$NOTIF_ID = 123456;

$TOKEN = "YOUR_TOKEN";

$ch = curl_init("https://api.pushe.co/v2/messaging/notifications/$NOTIF_ID/");

curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Content-Type: application/json",
    "Accept: application/json",
    "Authorization: Token " . $TOKEN,
));

curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$reponse = curl_exec($ch);
$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "status code => $status_code\n";
echo "response => $reponse\n";
echo "==========\n";

if ($status_code == 204) {
    echo "Success!\n";
} else {
    echo "failed!\n";
}
