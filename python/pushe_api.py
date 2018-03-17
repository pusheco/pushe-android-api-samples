import requests
import json

def sendSingleNotification(token,pushid,title,content,packagename):
    header = {
        "Authorization": "Token " + token
    }
    postdata ={
       
  "applications": [packagename],
  "filter": {
  "imei": [pushid]
  },
  "notification": {
    "title": title,
    "content": content
  }

    } 
    response = requests.post("https://panel.pushe.co/api/v1/notifications/",json=postdata, headers=header)
    jdata = json.loads(response.text)
    return jdata["applications"]

if __name__ == '__main__':
    sendSingleNotification(token,pushid,title,content,packagename)
      