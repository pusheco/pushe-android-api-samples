package main

/* get user pushe_id with this function in your application:
  ** Android **
// java code //
String pid = Pushe.getPusheId(this);
*/

/* get user device_id with this function in your website:
   ** Website **
   See:  https://pushe.co/docs/webpush/#unique_id

   Pushe.getDeviceId()
       .then((deviceId) => {
           console.log(`deviceId is: ${deviceId}`);
       });
*/

// send simple notification to 'YOUR_APPLICATION_ID'

import (
	"bytes"
	"encoding/json"
	"fmt"
	"net/http"
)

func main() {

	// obtain token -> https://pushe.co/docs/api/#api_get_token
	const token = "YOUR_TOKEN"

	reqData := map[string]interface{}{
		"app_ids":  []string{"YOUR_APP_ID"}, // a list of app_id, like: [app_id_1 , ...]
		"platform": 1,                                  // optional for android,
		// "platform": 2, for web (compulsive for web)
		"data": map[string]interface{}{
			"title":   "This is a simple push",         // (compulsive)
			"content": "All of your users will see me", // (compulsive)

			// for webpush we just support open link action
			// See web doc: https://pushe.co/docs/webpush-api/#webpush_api_action_type_table2

			// notification action
			// open app in market
			"action": map[string]interface{}{
				"action_type": "U",                                                             // (compulsive)
				"url":         "myket://application/#Intent;scheme=myket;package=package_name", // (compulsive)
			},
			// more actions -> https://pushe.co/docs/api/#api_action_type_table3

			// open activity action
			"buttons": []map[string]interface{}{ // list of dictionary
				{
					"btn_action": map[string]interface{}{
						"action_data":         "ActivityName",
						"action_type":         "T",
						"market_package_name": "",
						"url":                 "",
					},
					"btn_content": "content",
					"btn_icon":    "open_in_browser", // icons -> https://pushe.co/docs/api/#api_icon_notificaiton_table2
					"btn_order":   0,
				},
			},
		},
		// extra parameters on Documentation -> https://pushe.co/docs/api/#api_send_advance_notification
	}

	// Marshal returns the JSON encoding of reqData.
	reqJSON, err := json.Marshal(reqData)

	// check encoded json
	if err != nil {
		fmt.Println("json:", err)
		return
	}

	// create request obj
	request, err := http.NewRequest(
		http.MethodPost,
		"https://api.pushe.co/v2/messaging/notifications/",
		bytes.NewBuffer(reqJSON),
	)

	// check request
	if err != nil {
		fmt.Println("Req error:", err)
		return
	}

	// set header
	request.Header.Set("Content-Type", "application/json")
	request.Header.Set("Accept", "application/json")
	request.Header.Set("Authorization", "Token "+token)

	// send request and get response
	client := http.Client{}
	response, err := client.Do(request)

	// check response
	if err != nil {
		fmt.Println("Resp error:", err)
		return
	}

	defer response.Body.Close()

	// check status_code and response
	buf := new(bytes.Buffer)
	_, _ = buf.ReadFrom(response.Body)
	respContent := buf.String()

	fmt.Println("status code =>", response.StatusCode)
	fmt.Println("response =>", respContent)
	fmt.Println("==========")

	if response.StatusCode == http.StatusCreated {
		fmt.Println("success!")

		var respData map[string]interface{}
		_ = json.Unmarshal(buf.Bytes(), &respData)

		var reportURL string

		// hashed_id just generated for Non-Free plan
		if respData["hashed_id"] != nil {
			reportURL = "https://pushe.co/report?id=" + respData["hashed_id"].(string)
		} else {
			reportURL = "no report url for your plan"
		}

		fmt.Println("report_url:", reportURL)
		fmt.Println("notification id:", int(respData["wrapper_id"].(float64)))
	} else {
		fmt.Println("failed!")
	}
}
