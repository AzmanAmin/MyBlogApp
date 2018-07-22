@extends('layouts.master')

@section('content')

    <div class="col-md-10 col-md-offset-1">
        <p id="demo"></p>
        <script>
            var lat,lng;
            function initMap() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function (position) {
                        lat = position.coords.latitude;
                        lng = position.coords.longitude;

                        weatherApi();
                    });
                }
            }

            function weatherApi() {
                var url = "http://api.openweathermap.org/data/2.5/weather?lat="+lat+"&lon="+lng+"&units=metric&appid=173b53dbc273af80b2a8fc54a4de5e6f";

                $.getJSON(url, function(data) {
                    var image, main, description;
                    $.each(data.weather, function (index, val) {
                        image = "http://openweathermap.org/img/w/" + val.icon;
                        main = val.main;
                        description = val.description;
                    });

                    var text = "<b>" + data.name + "</b><img src=" + image + ".png><br>"
                        + data.main.temp + "&deg;C" + ' | ' + main + ', ' + description;
                    document.getElementById("demo").innerHTML = '' + text;
                });
            }

        </script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBmdUGJoHL87n5S0BzFGE2_hf6OALcPLz4&callback=initMap"></script>

        <h1>Admin Page</h1>
    </div>

@endsection