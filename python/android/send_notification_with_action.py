#!/usr/bin/env python
# vim: ts=4 sw=4 et

import requests

# obtain token -> https://pushe.co/docs/api/#api_get_token
TOKEN = 'YOUR_TOKEN'

# set header
headers = {
    'Authorization': 'Token ' + TOKEN,
    'Content-Type': 'application/json'
}

# Android -> https://pushe.co/docs/api/

data = {
    'app_ids': ['YOUR_APP_ID', ],
    'data': {
        'title': 'this is the title',
        'content': 'this is the content',
    },

    # Actions -> https://pushe.co/docs/api/#api_action_type_table3
    'action': {
        'action_type': 'U',
        'url': 'myket://application/#Intent;scheme=myket;package=package_name',
    },

    'buttons': [
        {
            'btn_action': {
                'action_data': 'ActivityName',
                'action_type': 'T',
                'market_package_name': '',
                'url': ''
            },
            'btn_content': 'content',
             # icons -> https: //pushe.co/docs/api/#api_icon_notificaiton_table2
            'btn_icon': 'open_in_browser',
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
