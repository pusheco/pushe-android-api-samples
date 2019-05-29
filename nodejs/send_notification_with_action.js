var request = require('request');

var TOKEN = "YOUR_TOKEN";


// Documentation:
//  (android) https://pushe.co/docs/api/#api_send_push_notification_to_single_users
//  (web) https://pushe.co/docs/webpush-api/#api_send_push_notification_according_to_device_id

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
            "app_ids": ["APP_ID_1"],
            "platform": 1, // optional for android
            // 'platform' : 2 for web (compulsive)
            "data": {
                "title": "This ia the title", // (compulsive)
                "content": "This is the content", // (compulsive)
                // for web we only support open link action
                // Documentation : https://pushe.co/docs/webpush-api/#webpush_api_action_type_table2

                // open link action
                "action": {
                    "action_type": "U",
                    "url": "https://pushe.co"
                },
                "buttons": [
                    {
                        'btn_action': {
                            'action_data': 'ActivityName',
                            'action_type': 'T',
                            'market_package_name': '',
                            'url': ''
                        },
                        'btn_content': 'content',
                        // btn_icon only support for android
                        'btn_icon': 'open_in_browser',  // icons -> https: //pushe.co/docs/api/#api_icon_notificaiton_table2
                        'btn_order': 0,
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
