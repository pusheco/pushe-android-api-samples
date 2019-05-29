# python 3.6

import requests

"""
  ** Android **
get user pushe_id with this function in your application:
// java code //
String pid = Pushe.getPusheId(this);

   ** Website **
get user device_id with this function in your website:
   See:  https://pushe.co/docs/webpush/#unique_id

   Pushe.getDeviceId()
       .then((deviceId) => {
           console.log(`deviceId is: ${deviceId}`);
       });
"""

# obtain token -> https://pushe.co/docs/api/#api_get_token
TOKEN = 'YOUR_TOKEN'

# set header
headers = {
    'Authorization': 'Token ' + TOKEN,
    'Content-Type': 'application/json'
}

# only for android
data = {
    'app_ids': ['APP_ID_1', ],
    'platform': 1,  # (optional for android)
    'data': {
        'title': 'this is the title',  # (compulsive)
        'content': 'this is the content',  # (compulsive)
    },
    'topics': ['TOPIC_1', 'TOPIC_2']
}

# send request
response = requests.post(
    'https://api.pushe.co/v2/messaging/notifications/',
    json=data,
    headers=headers,
)

# get status_code and response
print('status code => ', response.status_code)
print('response => ', response.json())
print('==========')

if response.status_code == 201:
    print('Success!')

    data = response.json()

    # hashed_id just generated for Non-Free plan
    if data['hashed_id']:
        report_url = 'https://pushe.co/report?id=%s' % data['hashed_id']
    else:
        report_url = 'no report url for your plan'

    notif_id = data['wrapper_id']
    print('report_url: %s' % report_url)
    print('notification id: %s' % notif_id)
else:
    print('failed')
