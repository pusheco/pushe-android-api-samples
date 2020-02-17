var request = require('request');

// Obtain token -> http://docs.pushe.co/docs/mobile-api/authentication/
var TOKEN = "YOUR_TOKEN";

// Android doc -> http://docs.pushe.co/docs/mobile-api/send_notification/

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
                "title": "This is a notification with buttons",
                "content": "In this notification, every button has an action.",

                "action": {
                    "id": "open_link",
                    "action_type": "U",
                    "url": "https://google.com"},
                "buttons": [
                    {
                        "btn_content": "Open App",
                        "btn_action": {"action_type": "A"},
                        "btn_order": 0},
                    {
                        "btn_content": "Call",
                        "btn_action": {
                            "action_type": "U",
                            "url": "tel:02187654321"
                        },
                        "btn_order": 1
                    },
                    {
                        "btn_content": "Install App",
                        "btn_action": {
                            "action_type": "U",
                            "params": {"market": "bazaar", "package_name": "shop.barkat.app"},
                            "url": "bazaar://details?id=shop.barkat.app",
                            "market_package_name": "com.farsitel.bazaar"
                        },
                        "btn_icon": "add_box",
                        "btn_order": 2
                    }
                ]
            }
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
