using SimpleJSON;  //need this library
using LitJson;   //need this library
//search up library in google and download it and import your project


public void sending() {
  StartCoroutine (send());
}


private IEnumerator send() {
  var encoding = new System.Text.UTF8Encoding();
  Dictionary<string, string> postHeader = new Dictionary<string, string>();

  string url = "https://panel.pushe.co/api/v1/notifications/";
  JSONClass jsonObject = new JSONClass();
  JSONArray listNode = new JSONArray();
  JSONNode N = new JSONClass();
  N["title"] = "title";  //change by your title
  N["content"] = "content";  //change by your contect
  jsonObject.Add("notification",N);
  jsonObject.Add("applications", listNode);
  listNode.Add(new JSONData("YOUR_APPLICATION_ID")   );  //change by your application name
  string json = jsonObject.ToString();

  postHeader.Add("Content-Type", "application/json");
  postHeader.Add("Accept", "application/json");

  postHeader.Add("Authorization","Token YOUR_TOKEN");   //replace your token string by YourToken string in line


  WWW www = new WWW(url, encoding.GetBytes(json), postHeader);
  yield return www;
  if (www.error == null) {
    Debug.Log (www.data);

  } else {
    Debug.Log (www.error);
  }
}
