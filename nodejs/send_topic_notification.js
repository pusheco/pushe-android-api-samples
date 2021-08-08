var request = require('request');

// Obtain token -> http://docs.pushe.co/docs/mobile-api/authentication/
var TOKEN = "YOUR_TOKEN";

// Android doc -> http://docs.pushe.co/docs/mobile-api/topic-notification/

// In order to send a notification to iOS applications use this url
// https://api.pushe.co/v2/messaging/notifications/ios

request.post(
    {
        uri: "https://api.pushe.co/v2/messaging/notifications/",
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "Authorization": "Token " + TOKEN,
        },
        body: JSON.stringify({
            "app_ids": ["YOUR_APP_ID"],
            "data": {
                "title": "This is a topic notification",
                "content": "Only users that subscribed to specified topics will see this notification",
            },
            "topics": ["TOPIC_1", "TOPIC_2"]
            // additional keywords -> https://pushe.co/docs/api/#api_send_advance_notification
        }),
    },
    function (error, response, body) {
        console.log("status_code: " + response.statusCode);
        console.log("response: " + body);

        if (response.statusCode == 201) {
            console.log("Success!");

            var data = JSON.parse(body);
            var report_url;

            if (data.hashed_id) {
                report_url = "https://pushe.co/report?id=" + data.hashed_id;
            } else {
                report_url = "no report url for your plan";
            }

            console.log("report_url: " + report_url);

            console.log("notification id: " + data.wrapper_id);
        } else {
            console.log("failed!");
        }
    }
);
