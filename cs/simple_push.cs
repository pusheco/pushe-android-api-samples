
public partial class Admin_Users : System.Web.UI.Page
{
    protected void Page_Load(object sender, EventArgs e)
    {
        var httpWebRequest = (HttpWebRequest)WebRequest.Create("https://panel.pushe.co/api/v1/notifications/");
        httpWebRequest.ContentType = "application/json";
        httpWebRequest.Accept = "application/json";
        httpWebRequest.Method = "POST";
        httpWebRequest.Headers.Add("Authorization", "Token YOUR_TOKEN"

        string jsonData = "{\"applications\":[\"YOUR_APPLICATION_ID\"],\"notification\":{\"title\": \"title\",\"content\":\"content\"}}";

        using (var streamWriter = new StreamWriter(httpWebRequest.GetRequestStream()))
        {
            streamWriter.Write(jsonData);
            streamWriter.Flush();
            streamWriter.Close();

            var httpResponse = (HttpWebResponse)httpWebRequest.GetResponse();
        }

     }
}
