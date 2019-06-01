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

# Webpush -> https://pushe.co/docs/webpush-api/

data = {
    'app_ids': ['YOUR_APP_ID', ],
    'platform': 2,
    'data': {
        'title': 'this is the title',
        'content': 'this is the content',
    },

    # Actions -> https://pushe.co/docs/webpush-api/#webpush_api_action_type_table2
    'action': {
        'action_type': 'U',
        'url': 'https://pushe.co',
    },

    'buttons': [
        {
            'btn_content': 'YOUR_CONTENT',
            'btn_action': {
                'action_data': 'ActivityName',
                'action_type': 'T',
                'market_package_name': '',
                'url': ''
            },
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

    # hashed_id only generated for Non-Free plan
    if data['hashed_id']:
        report_url = 'https://pushe.co/report?id=%s' % data['hashed_id']
    else:
        report_url = 'no report url for your plan'

    notif_id = data['wrapper_id']
    print('report_url: %s' % report_url)
    print('notification id: %s' % notif_id)
else:
    print('failed')
