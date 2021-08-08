package main

import (
	"bytes"
	"encoding/json"
	"fmt"
	"net/http"
)

func main() {

	// Obtain token -> http://docs.pushe.co/docs/mobile-api/authentication/
	const token = "YOUR_TOKEN"

	// Android -> http://docs.pushe.co/docs/mobile-api/filtered-notification/

    // In order to send a notification to iOS applications use this url
    // https://api.pushe.co/v2/messaging/notifications/ios
    
	data := map[string]interface{}{
		"app_ids": []string{"YOUR_APP_ID"},
		// send notification to all applications
        // "app_ids":  []string{"__all__"}
		"data": map[string]interface{}{
			"title":   "This is a filtered push",
			"content": "Only users with specified device_id(s) will see this notification.",
		},
		"filters": map[string]interface{}{
			"device_id": []string{"DEVICE_ID_1","DEVICE_ID_2"},
			"brand": []string{"samsung", "sony"},
            		"app_version": []string{"1.0.1", "1.0.2"}
		},
	}

	// Marshal returns the JSON encoding of reqData.
	reqJSON, err := json.Marshal(data)

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
