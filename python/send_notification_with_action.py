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

data = {
    'app_ids': ['APP_ID_1', ],
    'platform': 1,  # (optional for android)
    # 'platform': 2 , web (compulsive)
    'data': {
        'title': 'this is the title',  # (compulsive)
        'content': 'this is the content',  # (compulsive)
    },
    'action': {
        'action_type': 'U',
        'url': 'myket://application/#Intent;scheme=myket;package=package_name',
    },  # more actions -> https://pushe.co/docs/api/#api_action_type_table3

    # for web push we just support open link action
    # See : https://pushe.co/docs/webpush-api/#webpush_api_action_type_table2

    # notification buttons
    'buttons': [
        # open activity action
        # more actions -> https://pushe.co/docs/api/#api_action_type_table3
        {
            'btn_action': {
                'action_data': 'ActivityName',
                'action_type': 'T',
                'market_package_name': '',
                'url': ''
            },
            'btn_content': 'content',
            # 'btn_icon' only support in Android
            'btn_icon': 'open_in_browser',  # icons -> https: //pushe.co/docs/api/#api_icon_notificaiton_table2
            'btn_order': 0,
        }
    ],
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
