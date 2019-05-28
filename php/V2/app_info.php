<?php

// obtain token -> https://pushe.co/docs/api/#api_get_token
$TOKEN = "YOUR_TOKEN";

// web_push API doc -> https://pushe.co/docs/webpush/
//  Android API doc -> https://pushe.co/docs/webpush/

// for getting web applications -> https://api.pushe.co/v2/applications/web/
// for getting android applications -> https://api.pushe.co/v2/applications/android/
// for getting ios applications -> https://api.pushe.co/v2/applications/ios/ (Coming Soon)
$url = "https://api.pushe.co/v2/applications/android/";

// initialize curl
$ch = curl_init($url);

// set header parameters
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Content-Type: application/json",
    "Accept: application/json",
    "Authorization: Token " . $TOKEN,
));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// execute curl
$response = curl_exec($ch);

echo "response \n";
print_r($response);

$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

echo "status code \n";
// expected 200
print_r($status_code);

// recommended:
// store your application's app_id


// close curl
curl_close($ch);

?>