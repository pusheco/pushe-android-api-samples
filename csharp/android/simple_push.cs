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
            data.Add("title", "title");
            data.Add("content", "content");

            var request_data = new JObject();
            request_data.Add("app_ids", new JArray(new String[] { "YOUR_APPLICATION_ID" }));
            request_data.Add("data", data);


            Console.WriteLine("Request data: " + request_data.ToString());

            return new StringContent(request_data.ToString(), Encoding.UTF8, "application/json");
        }
    }
}
