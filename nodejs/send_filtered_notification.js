var request = require('request');

var TOKEN = "YOUR_TOKEN";


// Documentation:
//  (android) https://pushe.co/docs/api/#api_send_push_notification_to_single_users
//  (web) https://pushe.co/docs/webpush-api/#api_send_push_notification_according_to_device_id

// ********************************************************************
// ****************** filtered by device_id ***************************
// ******************** For Android and Web ***************************
// ********************************************************************

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
            "app_ids": ["APP_ID_1"], // (compulsive)
            "platform": 1, // optional for android
            // 'platform' : 2 for web (compulsive)
            "data": {
                "title": "This ia the title", // (compulsive)
                "content": "This is the content", // (compulsive)
            },
            "filters": {
                "device_id": ["DEVICE_ID_1", "DEVICE_ID_2"]
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

// ********************************************************************
// ********************** filtered by pushe_id ************************
// ************************ For Android *******************************
// ********************************************************************
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
            "app_ids": ["co.pushe.apushe163test"], // (compulsive)
            "platform": 1, // optional for android
            "data": {
                "title": "This ia the title", // (compulsive)
                "content": "This is the content", // (compulsive)
            },
            "filters": {
                "pushe_id": ["pid-***********", "pid-***********"]
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
