var request = require('request');
   

    var headers = {
        'content-type': 'application/json','Authorization':'Token your_token','Accept':'application/json'
    };

    var requestData = {
        applications: ["com.example.test"],
        notification: {
            title: "عنوان پیام",
            content: "محتوی پیام"
        }
        // ,"filter": {
        //     "instance_id": [device_id]
        // }
    };

    request({
        url: "https://panel.pushe.co/api/v1/notifications/",
        json: true,
        headers: headers,method:'POST',
        body: requestData
    }, function(error, response, body) {
        console.log(response)
        resp.send("err: "+error+" body:"+body)
    });
