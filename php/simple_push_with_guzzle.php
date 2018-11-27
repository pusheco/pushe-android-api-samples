<?php

$TOKEN = 'YOUR_TOKEN';

$client = new GuzzleHttp\Client([
  'headers' => [
    'Authorization' => 'Token ' . $TOKEN,
    'Content-Type' => 'application/json' ,
    'Accept' => 'application/json',
  ]
]);

$response = $client -> post (
  'https://panel.pushe.co/api/v1/notifications/' ,
  [
    'body' => json_encode ([
      'applications' => [ 'YOUR_APPLICATION_ID' ],
      'notification' => [
        'title' => 'this is the title',
        'content' => 'this is the content',
      ]
    ])
  ]
);

?>
