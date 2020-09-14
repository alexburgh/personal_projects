using System;
using System.Collections.Generic;
using System.Net.Http;
using System.Net.Http.Headers;
using System.Text;
using System.Threading.Tasks;

namespace WeatherApp.Helper {
    public class ApiCaller {
        public static async Task<ApiResponse> Get(string url, string authId = null) {
            using (var client = new HttpClient()) { // instantiate a new HttpClient object to handle http requests from API
                if (!string.IsNullOrWhiteSpace(authId)) // if an authentication ID is present
                    client.DefaultRequestHeaders.Authorization = new AuthenticationHeaderValue("Authorization", authId); // produces Authorization: ACCESS_TOKEN

                var request = await client.GetAsync(url);
                if (request.IsSuccessStatusCode) { // if the HTTP response was successful
                    return new ApiResponse { Response = await request.Content.ReadAsStringAsync() }; 
                } else {
                    return new ApiResponse { ErrorMessage = request.ReasonPhrase };
                }
            }
        }
    }

    public class ApiResponse {
        public bool SuccessfulCall => ErrorMessage == null; // if there is no error message, the API call was successful
        public string ErrorMessage { get; set; }

        public string Response { get; set; }
    }
}
