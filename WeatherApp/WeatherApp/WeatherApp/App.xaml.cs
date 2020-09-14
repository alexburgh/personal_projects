using WeatherApp.Views; // include the views folder 
using System;
using Xamarin.Forms;
using Xamarin.Forms.Xaml;

namespace WeatherApp {
    public partial class App : Application {
        public static string FilePath;
        public static string CustomLocation;

        public App() {
            InitializeComponent();

            MainPage = new NavigationPage(new CurrentWeatherPage());
        }

        // override constructor with a parameter constructor
        public App(string filePath) {
            InitializeComponent();

            MainPage = new NavigationPage(new CurrentWeatherPage());

            FilePath = filePath;
        }

        protected override void OnStart() {
        }

        protected override void OnSleep() {
        }

        protected override void OnResume() {
        }
    }
}
