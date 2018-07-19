var request = require('request');

var TOKEN = "YOUR_TOKEN"

var headers = {
    'content-type': 'application/json',
    'Authorization': 'Token ' + TOKEN,
    'Accept':'application/json',
};

var requestData = {
    applications: ["YOUR_APPLICATION_ID"],
    notification: {
        title:"this is the title",
        content: "this is the content",
    }
};

request(
    {
        url: "https://panel.pushe.co/api/v1/notifications/",
        json: true,
        headers: headers,
        method:'POST',
        body: requestData
    },
    function(error, response, body) {
        console.log(response)
        resp.send("err: "+error+" body:"+body)
    }
);
