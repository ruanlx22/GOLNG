<!DOCTYPE html>
<html>
    <head>
        <title>GO LNG</title>
        <style>
            #map {
                height: 100%;
            }
            html, body {
                height: 100%;
                margin: 0;
                padding: 0;
            }
        </style>
    </head>
    <body>
    <div id="map"></div>
    <div><p>aaa</p></div>
    <script>
        var map;
        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: 59.304762, lng: 18.080974},
                zoom: 6
            });
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAtelxbrcYzsm362x1oz4vOZaLLQp6lv0k&callback=initMap"
            async defer></script>
    </body>
</html>