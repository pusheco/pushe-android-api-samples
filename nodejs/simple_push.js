var request = require('request');

let TOKEN = "YOUR_TOKEN";

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
            "app_ids": ["YOUR_APPLICATION_ID"],
            "data": {
                "title": "This ia the title",
                "content": "This is the content",
            }
        }),
    },
    (error, response, body) => {
        console.log(`status_code: ${response.statusCode}`)
        console.log(`response: ${body}`);

        if (response.statusCode == 201){
            console.log("Success!");

            var data = JSON.parse(body);
            let report_url;

            if (data.hashed_id) {
                report_url = `https://pushe.co/report?id=${data.hashed_id}`;
            } else {
                report_url = "no report url for your plan";
            }

            console.log(`report_url: ${report_url}`);

            console.log(`notification id: ${data.wrapper_id}`);
        } else {
            console.log("failed!");
        }
    }
);
