public void sendPostRequest(final String notifJson) {

    new AsyncTask(){

        @Override
        protected Void doInBackground(Object[] objects) {
            OkHttpClient client = new OkHttpClient();
            MediaType JSON = MediaType.parse("application/json; charset=utf-8");
            try {
                JSONObject jsonObject = new JSONObject(notifJson);


                RequestBody body = RequestBody.create(JSON, jsonObject.toString());
                Request request = new Request.Builder()
                    .url("https://panel.pushe.co/api/v1/notifications/")
                    .post(body)
                    .addHeader("content-type", "application/json; charset=utf-8")
                    .addHeader("Authorization", "Token YOUR_TOKEN") //use your token here as TOKEN
                    .addHeader("Accept", "application/json")
                    .build();

                client.newCall(request).enqueue(new Callback() {

                    @Override
                    public void onFailure(Call call, IOException e) {
                        Log.e("response", call.request().body().toString());

                    }

                    @Override
                    public void onResponse(Call call, Response response) throws IOException {
                        Log.e("response", response.body().string());
                    }

                });

            } catch (JSONException e) {
                Log.e("pushe", e.getMessage());
            }

            return null;
        }
    }.execute();

}
