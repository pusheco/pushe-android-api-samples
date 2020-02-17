using System;
using System.Net.Http;
using System.Text;
// https://www.nuget.org/packages/Newtonsoft.Json/
using Newtonsoft.Json.Linq;
// https://www.nuget.org/packages/Nito.AsyncEx/
using Nito.AsyncEx;

namespace csharp
{
    class Program
    {
        // Android doc -> http://docs.pushe.co/docs/mobile-api/send_notification/
        // Obtain token -> http://docs.pushe.co/docs/mobile-api/authentication/
        static String token = "YOUR_TOKEN";

        static void Main(string[] args)
        {
            AsyncContext.Run(() => sendNotification());
        }

        public static async void sendNotification()
        {
            var client = new HttpClient();
            client.DefaultRequestHeaders.Add("Authorization", "Token " + token);

            var response = await client.PostAsync(
                "https://api.pushe.co/v2/messaging/notifications/",
                getNotificationData()
            );
            // In order to send a notification to iOS applications use this url
            // https://api.pushe.co/v2/messaging/notifications/ios

            var status_code = (int)response.StatusCode;
            var reponse_json = JObject.Parse(await response.Content.ReadAsStringAsync());

            Console.WriteLine("status code => " + status_code);
            Console.WriteLine("response => " + reponse_json.ToString());
            Console.WriteLine("==========");

            if (status_code == 201)
            {
                Console.WriteLine("Success!");

                var hashed_id = reponse_json.GetValue("hashed_id").ToString();
                String report_url;

                if (String.IsNullOrEmpty(hashed_id))
                {
                    report_url = "no report url for your plan";
                }
                else
                {
                    report_url = "https://pushe.co/report?id=" + hashed_id;
                }
                Console.WriteLine("report_url: " + report_url);

                var notif_id = reponse_json.GetValue("wrapper_id").ToString();
                Console.WriteLine("notification id: " + notif_id);
            }
            else
            {
                Console.WriteLine("failed!");
            }
        }

        public static StringContent getNotificationData()
        {
            var data = new JObject();
            data.Add("title", "This is a notification with buttons");
            data.Add("content", "In this notification, every button has an action.");

            var action = new JObject();
            action.Add("action_type", "U");
            action.Add("url", "https://pushe.co");

            var openAppAction = new JObject();
            openAppAction.Add("action_type", "A");

            var tellAction = new JObject();
            tellAction.Add("action_type", "U");
            tellAction.Add("url", "tel:02187654321");

            var marketActionParams = new JObject();
            marketActionParams.Add("market", "bazaar");
            marketActionParams.Add("package_name", "shop.barkat.app");
            
            var installAppAction = new JObject();
            installAppAction.Add("action_type", "U");
            installAppAction.Add("url", "bazaar://details?id=shop.barkat.app");
            installAppAction.Add("market_package_name", "com.farsitel.bazaar");
            installAppAction.Add("params", marketActionParams);

            var openAppBtn = new JObject();
            openAppBtn.Add("btn_content", "Open App");
            openAppBtn.Add("btn_order", 0);
            openAppBtn.Add("btn_action", openAppAction);

            var tellBtn = new JObject();
            tellBtn.Add("btn_content", "YOUR_CONTENT");
            tellBtn.Add("btn_order", 1);
            tellBtn.Add("btn_action", tellAction);

            var installAppBtn = new JObject();
            installAppBtn.Add("btn_content", "Install App");
            installAppBtn.Add("btn_order", 1);
            installAppBtn.Add("btn_action", installAppAction);
            
            data.Add("action",action);
            data.add("buttons",new JArray(new JObject[]{openAppBtn,tellBtn,installAppBtn}));
            
            var request_data = new JObject();
            request_data.Add("app_ids", new JArray(new String[] { "YOUR_APPLICATION_ID" }));
            request_data.Add("data", data);


            Console.WriteLine("Request data: " + request_data.ToString());

            return new StringContent(request_data.ToString(), Encoding.UTF8, "application/json");
        }
    }
}
