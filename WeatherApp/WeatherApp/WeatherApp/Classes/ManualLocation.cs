using SQLite;
using System;
using System.Collections.Generic;
using System.Text;

namespace WeatherApp.Classes {
    class ManualLocation {
        [PrimaryKey, AutoIncrement]
        public int Id { get; set; }

        public string City { get; set; }
    }
}
