<?php

$TOKEN = "YOUR_TOKEN";

// link to first page
$link = "http://panel.pushe.co/api/v1/applications/";

while( true ){
    $ch = curl_init($link);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
        "Content-Type: application/json",
        "Accept: application/json",
        "Authorization: Token " . $TOKEN,
    ));

    $output = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($http_code == 200){
        $output = json_decode($output);
        if (! $output){
            // when there is no data in response
            // stop fetching apps info
            break;
        }
        // link to next page (each page contains 20 apps)
        $link = $output->next;

        $results = $output->results;

        foreach($results as $result){
            // here is the data for each app in fetched page
            echo $result->name . ', ' . $result->application_id . ', ' . $result->active_users;
        }

    } else {
        // error
        echo $output;
        break;
    }
}
