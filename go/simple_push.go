package main

import (
	"bytes"
	"encoding/json"
	"fmt"
	"net/http"
)

const token = "YOUR_TOKEN"

func main() {
	reqData := map[string]interface{}{
		"app_ids": []string{"YOUR_APPLICATION_ID"},
		"data": map[string]interface{}{
			"title":   "This is a simple push",
			"content": "All of your users will see me",
		},
	}

	reqJSON, err := json.Marshal(reqData)

	if err != nil {
		fmt.Println("json:", err)
		return
	}

	req, err := http.NewRequest(
		http.MethodPost,
		"https://api.pushe.co/v2/messaging/notifications/",
		bytes.NewBuffer(reqJSON),
	)
	req.Header.Add("Content-Type", "application/json")
	req.Header.Add("Accept", "application/json")
	req.Header.Add("Authorization", "Token "+token)

	if err != nil {
		fmt.Println("Req error:", err)
		return
	}

	client := http.Client{}
	resp, err := client.Do(req)

	if err != nil {
		fmt.Println("Resp error:", err)
		return
	}
	defer resp.Body.Close()

	buf := new(bytes.Buffer)
	buf.ReadFrom(resp.Body)
	respContent := buf.String()

	fmt.Println("status code =>", resp.StatusCode)
	fmt.Println("response =>", respContent)
	fmt.Println("==========")

	if resp.StatusCode == http.StatusCreated {
		fmt.Println("success!")

		var respData map[string]interface{}
		json.Unmarshal(buf.Bytes(), &respData)

		var reportURL string

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
