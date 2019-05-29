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

# Documentation :  (android) https://pushe.co/docs/api/#api_send_push_notification_to_single_users
# 					(web) https://pushe.co/docs/webpush-api/#api_send_push_notification_according_to_device_id
# **********************************************************
# **************** filtered with pushe_id ******************
# ********************* For Android ************************
# **********************************************************
pushe_id_filtered_data = {
    'app_ids': ['APP_ID_1', ],
    'data': {
        'title': 'this is the title',  # (compulsive)
        'content': 'this is the content',  # (compulsive)
    },
    'filters': {
        'pushe_id': ['pid-*************', 'pid-*************']
    },
}

# **********************************************************
# **************** filtered with pushe_id ******************
# ***************** For Android and web ********************
# **********************************************************
device_id_filtered_data = {
    'app_ids': ['co.pushe.apushe163test', ],
    'platform': 1,  # (optional for android)
    # 'platform': 2 , web (compulsive)
    'data': {
        'title': 'this is the title',  # (compulsive)
        'content': 'this is the content',  # (compulsive)
    },
    'filters': {
        'device_id': ['DEIVCE_ID_1', 'DEVICE_ID_2']
    },
}

response = requests.post(
    'https://api.pushe.co/v2/messaging/notifications/',
    json=pushe_id_filtered_data,
    headers=headers,
)

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
