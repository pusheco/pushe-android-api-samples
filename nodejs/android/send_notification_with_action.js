var request = require('request');

var TOKEN = "YOUR_TOKEN";

// Android -> https://pushe.co/docs/api/

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
                "title": "This ia the title",
                "content": "This is the content",

                // Actions -> https://pushe.co/docs/api/#api_action_type_table3
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
                        // icons -> https: //pushe.co/docs/api/#api_icon_notificaiton_table2
                        'btn_icon': 'open_in_browser',
                        'btn_order': 0,
                    }
                ]
            }
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
