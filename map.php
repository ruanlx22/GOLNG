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
//echo "company info get successfully!" . "</br>";
$sql = "SELECT * FROM company";
$results = mysqli_query($conn,$sql);
if ($results){
//    echo "company info get successfully!" . "</br>";
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

function matchCategory($category){
    $category_label;
    switch ($category) {
        case "Bunkering":
            $category_label = 'B';
            break;
        case "Consulting":
            $category_label = 'C';
            break;
        case 'Education':
            $category_label = 'Edu';
            break;
        case 'end-user technologies':
            $category_label = 'eut';
            break;
        case 'Ports':
            $category_label = 'P';
            break;
        case 'Research':
            $category_label = 'R';
            break;
        case 'Shipbuilding':
            $category_label = 'Spb';
            break;
        case 'Shipping':
            $category_label = 'Sb';
            break;
        case 'Shipbuilding & Repair':
            $category_label = 'S&R';
            break;
        case 'Storage':
            $category_label = 'Stor';
            break;
        case 'Training':
            $category_label = 'T';
            break;
        default:
            $category_label = '9';
            break;
    }
    return $category_label;
}

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
    <script>
        var customLabel = {
                Bunkering: {
                    label: 'B'
                },
                Consulting: {
                    label: 'C'
                },
                Education: {
                    label: 'E'
                },
                End-user technologies:{
                    label: 'e'
                },
                Ports: {
                    label: 'P'
                },
                Research: {
                    label: 'R'
                },
                Shipbuilding&Repair: {
                    label: 's'
                },
                Shipping: {
                    label: 'S'
                },
                Training: {
                    label: 'T'
                }
            };
            
    </script>
    <script type="text/javascript" >
        function initMap() {
            
            var map = new google.maps.Map(document.getElementById('map'),{
                zoom: 5,
                center: {lat: 59.304,lng: 18.080},
                styles: [
                    
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
            
            <?php
            foreach ($companyArray as $sc){
                $count++;
                // echo $sc->getCategory();
                // echo "var category = markerElem.getAttribute('".$sc->getCategory()."');";
                // echo "var icon = customLabel[category] || {};";label: customLabel[".$sc->getCategory()."].  label:'".substr($sc->getCategory(), 0,1)."'
                if($sc->getLat()!=null&&$sc->getLon()!=null){
                    
                    echo "
                    var marker".$count." = new google.maps.Marker({
                    position: {lat:".$sc->getLat()." ,lng:".$sc->getLon()."},
                    map:map,
                    label:{ text: '".matchCategory($sc->getCategory())."'}
                    });
                    var contentString".$count." =
                    '<div>'
                        +'<p>Company: ".$sc->getName()."</p>'
                        +'<img src=\'".$sc->getImage()."\'>'
                        +'<br>'
                        +'<p>".htmlentities($sc->getDescription(), ENT_QUOTES)."</p>'
                        +'<a href=\'".$sc->getUrl()."\'>Link</a>'
                     +'</div>';
                    var infoWindow".$count." = new google.maps.InfoWindow({
                        content: contentString".$count."
                    });
                    marker".$count.".addListener('click', function() {
                        infoWindow".$count.".open(map, marker".$count.");
                    });
                    ";

                }

            }
            ?>
        }
    </script>

    </body>
</html>