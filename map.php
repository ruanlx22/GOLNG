<?php
require_once('company.php');
$USER = 'root';
$PASSWORD = '';
$SERVER = 'localhost';
$DB = 'GOLNG';

$conn = mysqli_connect($SERVER, $USER, $PASSWORD, $DB);

if (!$conn){
    die("Connection to DB failed :" . mysqli_connect_error() . "</br>");
}

echo  "Successfully connected to DB!" . "</br>";

$sql = "SELECT * FROM company";
$results = mysqli_query($conn,$sql);
if ($results){
    echo "company info get successfully!" . "</br>";
} else {
    echo "Error get company info!" . $connection->error . "</br>" ;
}
$count = 0;
$companyArray = [];
while($row = $results->fetch_assoc()){
//    $count++;
    $company = new company($row['id'],$row['name'],$row['lat'],$row['lon'],$row['description'],$row['url'],$row['image'],$row['category']);
    $companyArray[] = $company;
}

//foreach ($companyArray as $sc){
//    echo $sc->getLat()."  ".$sc->getLon()."<br>";
//}

?>
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
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAtelxbrcYzsm362x1oz4vOZaLLQp6lv0k&callback=initMap"
            async defer>        
    </script>
    <script type="text/javascript" >
        function initMap() {
            // var myLabel2 = {lat: 59.304,lng: 18.080};
            // var myLabel = {lat:-25.363, lng:131.044};
            var map = new google.maps.Map(document.getElementById('map'),{
                zoom: 5,
                center: {lat: 59.304,lng: 18.080},
                styles: [
                    {
                        "elementType": "geometry",
                        "stylers": [
                            {
                                "color": "#f5f5f5"
                            }
                        ]
                    },
                    {
                        "featureType": "administrative.land_parcel",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "administrative.neighborhood",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "landscape.man_made",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "landscape.natural",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "landscape.natural.landcover",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "landscape.natural.terrain",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "poi",
                        "elementType": "labels.text",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "poi.business",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "poi.park",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "poi.park",
                        "elementType": "geometry",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "poi.park",
                        "elementType": "labels",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "poi.park",
                        "elementType": "labels.icon",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "road",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "road",
                        "elementType": "labels",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "road",
                        "elementType": "labels.icon",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "transit",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    },
                    {
                        "featureType": "water",
                        "elementType": "labels.text",
                        "stylers": [
                            {
                                "visibility": "off"
                            }
                        ]
                    }
                ]
            });
            // var marker = new google.maps.Marker({
            //     position: myLabel,
            //     map: map
            // });
            // var marker2 = new google.maps.Marker({
            //     position: myLabel2,
            //     map: map
            // });
            <?php
            foreach ($companyArray as $sc){
                $count++;
                if($sc->getLat()!=null&&$sc->getLon()!=null){
                    echo "
                    var marker".$count." = new google.maps.Marker({
                    position: {lat:".$sc->getLat()." ,lng:".$sc->getLon()."},
                    map:map
                    });
                    ";
                }

            }
            ?>
        }
    </script>

    </body>
</html>