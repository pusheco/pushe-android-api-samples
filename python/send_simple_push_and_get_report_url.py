# python 3.6

import requests

TOKEN = '2746e8cf5ebe571670166ed84621a5c15b13bb2a'

headers = {
    'Authorization': 'Token ' + TOKEN
}

data = {
    'app_ids': ['co.pushe.apushe163test', ],
    'data': {
        'title': 'this is the title',
        'content': 'this is the content',
    }
}

response = requests.post(
    'https://api.pushe.co/v2/messaging/notifications/',
    json=data,
    headers=headers,
)

print('status code => ', response.status_code)
print('response => ', response.json())
print('==========')

if response.status_code == 201:
    print('Success!')

    data = response.json()

    if data['hashed_id']:
        report_url = 'https://pushe.co/report?id=%s' % data['hashed_id']
    else:
        report_url = 'no report url for your plan'

    notif_id = data['wrapper_id']
    print('report_url: %s' % report_url)
    print('notification id: %s' % notif_id)
else:
    print('failed')
