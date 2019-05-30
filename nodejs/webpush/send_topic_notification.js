var request = require('request');

var TOKEN = "YOUR_TOKEN";

// Android -> https://pushe.co/docs/webpush-api/

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
            "platform": 2,
            "data": {
                "title": "This is a topic push",
                "content": "Only users that subscribed to specified topics will see this notification",
            },
            "topics": ["TOPIC_1", "TOPIC_2"]
            // additional keywords -> https://pushe.co/docs/webpush-api/#api_send_advance_notification
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