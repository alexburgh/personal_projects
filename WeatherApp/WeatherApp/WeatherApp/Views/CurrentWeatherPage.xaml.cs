using Newtonsoft.Json;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Linq;
using WeatherApp.Helper;
using Xamarin.Forms;
using Xamarin.Forms.Xaml;
using WeatherApp.Models;
using Xamarin.Essentials; // needed for geolocation
using SQLite;
using WeatherApp.Classes;

namespace WeatherApp.Views {
    [XamlCompilation(XamlCompilationOptions.Compile)]
    public partial class CurrentWeatherPage : ContentPage {
        public CurrentWeatherPage() {
            InitializeComponent();
            NavigationPage.SetHasNavigationBar(this, false);
            
            // if no location was manually set, use geolocation
            if(Location == null) {
                GetCoordinates();
            } else {
                GetWeatherInfo();
                GetForecast();
            }
        }

        public CurrentWeatherPage(string customLocation) {
            InitializeComponent();
            NavigationPage.SetHasNavigationBar(this, false);
            Location = customLocation;

            if (Location == null) {
                GetCoordinates();
            } else {
                GetWeatherInfo();
                GetForecast();
            }
        }

        // define properties
        private string Location { get; set; }
        public double Latitude { get; set; }
        public double Longitude { get; set; }
        
        // method to get current location data by geolocation
        public async void GetCoordinates() {
            try {
                var request = new GeolocationRequest(GeolocationAccuracy.High); // create geolocation request
                var location = await Geolocation.GetLocationAsync(request); // request the current location (in latitude, longitude and altidude)

                if(location != null) {
                    Latitude = location.Latitude;
                    Longitude = location.Longitude;
                    Location = await GetCity(location); // get the city based on geolocation coordinates

                    GetWeatherInfo();
                    GetForecast();
                }

            } catch(Exception e) {
                Console.WriteLine(e.StackTrace);
            }
        }

        private async Task<string> GetCity(Location location) {
            var places = await Geocoding.GetPlacemarksAsync(location);
            var currentPlace = places?.FirstOrDefault();

            if(currentPlace != null) {
                return $"{currentPlace.Locality}, {currentPlace.CountryName}";
            } else {
                return null;
            }
        }

        // method to get weather info
        private async void GetWeatherInfo() {
            var url = $"http://api.openweathermap.org/data/2.5/weather?q={Location}&appid=7041682cdeff9cf9b9d86e68ad285807&units=metric";
            var result = await ApiCaller.Get(url); // call the Get method from ApiCaller class to get the API response

            if(result.SuccessfulCall) { // if an API response was succesfully returned 
                try {
                    var weatherInfo = JsonConvert.DeserializeObject<WeatherInfo>(result.Response); // JsonConvert is from a separate NuGet package

                    descriptionText.Text = weatherInfo.Weather[0].Description.ToUpper();
                    iconImg.Source = $"w{weatherInfo.Weather[0].Icon}";
                    cityText.Text = weatherInfo.Name.ToUpper();
                    temperatureText.Text = weatherInfo.Main.Temp.ToString("0");
                    humidityText.Text = $"{weatherInfo.Main.Humidity}%";
                    windText.Text = $"{weatherInfo.Wind.Speed} m/s";
                    pressureText.Text = $"{weatherInfo.Main.Pressure} hpa";
                    cloudinessText.Text = $"{weatherInfo.Clouds.All}";

                    double timestamp = weatherInfo.Dt;
                    DateTime dateTime = new DateTime(1970, 1, 1, 0, 0, 0, 0);
                    dateTime = dateTime.AddSeconds(timestamp).ToLocalTime();
                    dateText.Text = dateTime.ToString("dddd, MMM dd").ToUpper();

                } catch(Exception e) {
                    await DisplayAlert("Weather Info", "There was an error in retrieving the weather information.", "OK");
                }
                    
            } else {
                await DisplayAlert("No Weather Info", "Sorry, no weather information was found at the moment.", "Return");
            }
        }

        private async void GetForecast() {
            var url = $"http://api.openweathermap.org/data/2.5/forecast?q={Location}&appid=7041682cdeff9cf9b9d86e68ad285807&units=metric";
            var result = await ApiCaller.Get(url); // call the Get method from ApiCaller class to get the API response

            if (result.SuccessfulCall) { // if an API response was succesfully returned 
                try {
                    var forecastInfo = JsonConvert.DeserializeObject<ForecastInfo>(result.Response);

                    List<DayList> allDaysList = new List<DayList>();

                    foreach (var forecastList in forecastInfo.List) {
                        var date = DateTime.Parse(forecastList.Dt_txt);

                        if (date > DateTime.Now && date.Hour == 15) { // for the next days, at midnight
                            allDaysList.Add(forecastList); // get weather forecast parameters (a list for each day)
                        }
                    }

                    // bind data to the view
                    // 1st column
                    dayOneText.Text = DateTime.Parse(allDaysList[0].Dt_txt).ToString("dddd");
                    dateOneText.Text = DateTime.Parse(allDaysList[0].Dt_txt).ToString("dd MMM");
                    iconOneImg.Source = $"w{allDaysList[0].Weather[0].Icon}";
                    tempOneText.Text = allDaysList[0].Main.Temp_max.ToString("0");

                    // 2nd column
                    dayTwoText.Text = DateTime.Parse(allDaysList[1].Dt_txt).ToString("dddd");
                    dateTwoText.Text = DateTime.Parse(allDaysList[1].Dt_txt).ToString("dd MMM");
                    iconTwoImg.Source = $"w{allDaysList[1].Weather[0].Icon}";
                    tempTwoText.Text = allDaysList[1].Main.Temp_max.ToString("0");

                    // 3rd column
                    dayThreeText.Text = DateTime.Parse(allDaysList[2].Dt_txt).ToString("dddd");
                    dateThreeText.Text = DateTime.Parse(allDaysList[2].Dt_txt).ToString("dd MMM");
                    iconThreeImg.Source = $"w{allDaysList[2].Weather[0].Icon}";
                    tempThreeText.Text = allDaysList[2].Main.Temp_max.ToString("0");

                    // 4th column
                    dayFourText.Text = DateTime.Parse(allDaysList[3].Dt_txt).ToString("dddd");
                    dateFourText.Text = DateTime.Parse(allDaysList[3].Dt_txt).ToString("dd MMM");
                    iconFourImg.Source = $"w{allDaysList[3].Weather[0].Icon}";
                    tempFourText.Text = allDaysList[3].Main.Temp_max.ToString("0");

                } catch (Exception e) {
                    //await DisplayAlert("Error", e.Message, "OK");
                }
            } else {
                await DisplayAlert("Weather Info", "No weather information was found.", "OK");
            }
        }

        private async void Button_Clicked(object sender, EventArgs e) {
            await Navigation.PushAsync(new Page1());
        }
    }
    }