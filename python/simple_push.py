import requests
import json


TOKEN = 'YOUR_TOKEN'

headers = {
    'Authorization': 'Token ' + TOKEN
}

data = {
    'applications': ['YOUR_APPLICATION_ID', ],
    'notification': {
        'title': 'this is the title',
        'content': 'this is the content',
    }
}

response = requests.post(
    'https://panel.pushe.co/api/v1/notifications/',
    json=data,
    headers=headers,
)

resp = json.loads(response.text)

print(resp.status_code)
print(resp.json())
