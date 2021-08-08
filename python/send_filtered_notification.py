#!/usr/bin/env python
# vim: ts=4 sw=4 et

import requests

# Obtain token -> http://docs.pushe.co/docs/mobile-api/authentication/
TOKEN = 'YOUR_TOKEN'

# set header
headers = {
    'Authorization': 'Token ' + TOKEN,
    'Content-Type': 'application/json'
}

# Android doc -> http://docs.pushe.co/docs/mobile-api/filtered-notification/

data = {
    'app_ids': ['YOUR_APP_ID', ],
    'data': {
        'title': 'This is a filtered push',
        'content': 'Only users with specified device_id(s) will see this notification.',
    },
    'filters': {
        'device_id': ['DEIVCE_ID_1', 'DEVICE_ID_2'],
        "brand": ["samsung", "sony"], 
        "app_version": ["1.0.1", "1.0.2"]
    },
}

response = requests.post(
    'https://api.pushe.co/v2/messaging/notifications/',
    json=data,
    headers=headers,
)
# In order to send a notification to iOS applications use this url
# https://api.pushe.co/v2/messaging/notifications/ios/

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
