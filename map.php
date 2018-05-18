<?php
require_once('company.php');
session_start();
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
        <link rel="stylesheet" type="text/css" href="style.css">
        <style>
            #map {
                height: 100%;
            }
            #legend {
                background: #fff;
                padding: 10px;
                margin: 10px;
                border: 3px solid #000;
            }
            #filter {
                background: #fff;
                padding: 2px 10px 2px 10px;
                margin: 10px;
                border: 3px solid #000;
            }
        </style>
    </head>
    <body>

    <nav style="background-color: cadetblue;padding: 0;">
        <a href='map.php' class="navBar">Go LNG</a>
        <span> | </span>
        <?php
            if(isset($_SESSION['user'])){
                echo "<a class='navBar'>".$_SESSION['user'][1]->getName()."</a>";
                echo "<span> | </span><a class='navBar' href='logout.php'>Log out</a>";
            }
            else{
                echo "<a class='navBar' href='login.php'>Login</a>";
            }
        ?>
    </nav>

    <div id="map"></div>
    <div id="legend"><h2><center>Legend</center></h2></div>
    <div id="filter"></div>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAtelxbrcYzsm362x1oz4vOZaLLQp6lv0k&callback=initMap"
            async defer>        
    </script>
    <script type="text/javascript">
        function changeBtnState(btnState){
            if (btnState == true){
                btnState = false;
            }
            if (btnState == false){
                btnState == true;
            }
            return btnState;
        }

        function buttonChange(btnState){
            if (btnState==true) {
                btnState = changeBtnState(btnState)
                alert(btnState)
            }
            if (btnState==false) {
                btnState = changeBtnState(btnState)
                alert(btnState)
            }
        }
    </script>
    <script type="text/javascript" >

        function initMap() {
            
            var map = new google.maps.Map(document.getElementById('map'),{
                zoom: 5,
                center: {lat: 59.304,lng: 18.080},
                streetViewControl: false,
                mapTypeControl: false,
                // mapTypeControl: true,
                // mapTypeControlOptions: {
                //     style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
                //     mapTypeIds: ['roadmap']
                // }
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
            var infoWindow = new google.maps.InfoWindow;
            var categoryArray = new Array("Bunkering","Consulting","Education","end-user technologies","Ports","Research","Shipbuilding","Shipping","Shipbuilding & Repair","Storage","Training");
            var shortCategoryArray = new Array("B","C","Edu","eut","P","R","Spb","Sb","S&R","Stor","T");

            /*Here is the filter for map  */


            /*Here is the legend for map */
            var legend = document.getElementById('legend');
            var legend_table = document.createElement('table');
            legend.appendChild(legend_table);
            for (var key in categoryArray) {
                // var div = document.createElement('div');
                // div.innerHTML = '<tr><td width="20%">'+shortCategoryArray[key]+'</td><td width="30%"></td><td width="50%">'+categoryArray[key]+'</td></tr>';
                // table.appendChild(div);
                var tr = document.createElement('tr');
                var td1 =document.createElement('td');
                var td2 = document.createElement('td');
                td1.innerHTML = shortCategoryArray[key];
                td2.innerHTML = categoryArray[key];
                tr.appendChild(td1);
                tr.appendChild(td2);
                legend_table.appendChild(tr);

            }
            map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(legend);

            /*Here is the label info window*/
            var filter = document.getElementById('filter');
            for (key in categoryArray) {
                var btn = document.createElement('button');
                btn.innerHTML = shortCategoryArray[key];
                btn.id = shortCategoryArray[key];
                var temp_btn = document.getElementById(shortCategoryArray[key]);
                // temp_btn.onclick = buttonChange(true);
                /*add function for each button*/
                // var temp_btn = document.getElementById(shortCategoryArray[key]);
                // temp_btn.onclick = buttonChange();

                filter.appendChild(btn);
            }

            // for (key in categoryArray) {
            //     var temp_btn = document.getElementById(shortCategoryArray[key]);
            //     temp_btn.onclick = changeBtnState;
            // }

            map.controls[google.maps.ControlPosition.BOTTOM_CENTER].push(filter);
            <?php
            foreach ($companyArray as $sc){
                $count++;
                
                if($sc->getLat()!=null&&$sc->getLon()!=null){
//                    echo "
                    ?>
                    var marker<?php echo $count?> = new google.maps.Marker({
                    position: {lat:<?php echo $sc->getLat()?> ,lng:<?php echo $sc->getLon()?>},
                    map:map,
                    label:{ text: '<?php echo matchCategory($sc->getCategory())?>'}
                    });
                    var contentString<?php echo $count?> =
                    '<div>'
                        +'<p>Company: <?php echo $sc->getName() ?></p>'
                        +'<img src=\'<?php echo $sc->getImage() ?>\' class=\'logo\'>'
                        +'<br>'
                        +'<p><?php echo htmlentities($sc->getDescription(), ENT_QUOTES)?></p>'
                        +'<a href=\'<?php echo $sc->getUrl()?>\'>Link</a>'
                     +'</div>';
                    marker<?php echo $count?>.addListener('click', function() {
                        infoWindow.setContent(contentString<?php echo $count ?>);
                        infoWindow.open(map, marker<?php echo $count ?>);
                    });
                    map.addListener('click', function() {
                        infoWindow.close();
                    });
                    
                    // ";
            <?php

                }

            }
            ?>
        }
    </script>

    </body>
</html>