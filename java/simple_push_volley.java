public void sendMsg(){
    final String token="YOUR_TOKEN";
    String url="https://panel.pushe.co/api/v1/notifications/";

    try{
        JSONObject jsonBody=new JSONObject("{ \"applications\": [\"PACKAGE_NAME\"], \"notification\": { \"title\": \"عنوان پیام\", \"content\": \"محتوای پیام\" } }");
        JsonObjectRequest req=new JsonObjectRequest(url,jsonBody,

            new Response.Listener<JSONObject>(){
                @Override
                public void onResponse(JSONObject response){
                    Log.d("Response",response.toString());
                }
            },

            new Response.ErrorListener(){
                @Override
                public void onErrorResponse(VolleyError error){
                    Log.d("Error msg","error occured");
                }
            }
        ) {

            @Override
            public Map<String, String> getHeaders()throws AuthFailureError{
                Map<String, String> params=new HashMap<String, String>();
                params.put("Authorization","Token "+token);
                params.put("Content-Type","application/json");
                params.put("Accept","application/json");

                return params;
            }
        };
    queue.add(req);

    }catch(JSONException e){
        e.printStackTrace();
    }

}
