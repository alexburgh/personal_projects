using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

using Xamarin.Forms;
using Xamarin.Forms.Xaml;
using SQLite;
using WeatherApp.Classes;
using Xamarin.Essentials;

namespace WeatherApp.Views {
    [XamlCompilation(XamlCompilationOptions.Compile)]
    public partial class Page1 : ContentPage {
        public Page1() {
            InitializeComponent();
        }

        // event handler for insert location button
        private void submit_Clicked(object sender, EventArgs e) {
            ManualLocation location = new ManualLocation() {
                City = orasEntry.Text
            };

            using(SQLiteConnection conn = new SQLiteConnection(App.FilePath)) {
                conn.CreateTable<ManualLocation>();

                var existingEntries = conn.Query<ManualLocation>("SELECT * FROM ManualLocation WHERE City=?", location.City);
                
                // check whether the location inserted exists already
                if(existingEntries.Count > 0) {
                    DisplayAlert("Already inserted", "The location you inserted already exists!", "Return");
                } else {
                    int rowsAdded = conn.Insert(location); // returns an integer with the amount of rows that were added
                }

                // when a new location is added, read the table contents in the database and bind to listview
                var locations = conn.Table<ManualLocation>().ToList();
                locationsListView.ItemsSource = locations;
            }
        }

        // event handler for clear button
        private void clearList_Clicked(object sender, EventArgs e) {
            using (SQLiteConnection conn = new SQLiteConnection(App.FilePath)) {
                conn.Query<ManualLocation>("DELETE FROM ManualLocation");

                var locations = conn.Table<ManualLocation>().ToList();
                locationsListView.ItemsSource = locations;
            }
        }

        private void deleteLast_Clicked(object sender, EventArgs e) {
            using (SQLiteConnection conn = new SQLiteConnection(App.FilePath)) {
                conn.Query<ManualLocation>("DELETE FROM ManualLocation WHERE id = (SELECT MAX(id) FROM ManualLocation)");

                var locations = conn.Table<ManualLocation>().ToList();
                locationsListView.ItemsSource = locations;
            }
        }

        private async void locationSelected_Click(object sender, SelectedItemChangedEventArgs e) {
            await Navigation.PushAsync(new CurrentWeatherPage(((ManualLocation)((ListView)sender).SelectedItem).City));
        }

        // whenever the page is loaded, read the table contents in the database and bind to listview
        protected override void OnAppearing() { 
            base.OnAppearing();

            using (SQLiteConnection conn = new SQLiteConnection(App.FilePath)) {
                conn.CreateTable<ManualLocation>();
                var locations = conn.Table<ManualLocation>().ToList();
                locationsListView.ItemsSource = locations;
            }
        }
    }
}