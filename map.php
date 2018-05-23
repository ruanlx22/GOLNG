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
$relationshipArray = [];
while($row = $results->fetch_assoc()){
    $company = new company($row['id'],$row['name'],$row['lat'],$row['lon'],$row['description'],$row['url'],$row['image'],$row['category']);
    $companyArray[] = $company;
}

foreach ($companyArray as $com){
    $sqlRe = "SELECT * FROM relationship where (company_start = ".$com->getId()." or company_end = ".$com->getId().")";
    $resultRe = mysqli_query($conn,$sqlRe);
    if ($resultRe){

    } else {
        echo "Error get company info!" . $connection->error . "</br>" ;
    }
    $tempArray = [];
    while($row = $resultRe->fetch_assoc()){
        $tempArray[] = [$row['company_start'],$row['company_end']];
    }
    $relationshipArray[] = $tempArray;
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
        
        // function buttonChange(btnState, id){
        //     if (btnState==true) {
        //         // marker1.setMap(map);
        //         setMapOnAll(null);
        //     }
        //     if (btnState==false) {
        //         // marker.setMap(null);
        //         setMapOnAll(map);
        //     }
        // }

        // function changeBtnState(){
        //     if (this.state === undefined){
        //         this.state = true;
        //     }
        //     state = this.state;
        //     if (state == true){
        //         state = false;
        //     }else {
        //         state = true;
        //     }
        //     this.state=state;
        //     id = this.id;
        //     alert(buttonChange(state,id));

        // }
    </script>
    <script type="text/javascript" >
        var markerArray = [];
        var lineArray = [];
        function initMap() {
            
            var map = new google.maps.Map(document.getElementById('map'),{
                zoom: 5,
                center: {lat: 59.304,lng: 18.080},
                streetViewControl: false,
                mapTypeControl: false,
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
            
            // var markerArray = new Array();//markerArray
            
            var infoWindow = new google.maps.InfoWindow;
            var categoryArray = new Array("Bunkering","Consulting","Education","end-user technologies","Ports","Research","Shipbuilding","Shipping","Shipbuilding & Repair","Storage","Training");
            var shortCategoryArray = new Array("B","C","Edu","eut","P","R","Spb","Sb","S&R","Stor","T");

            /*Here is the legend for map */
            var legend = document.getElementById('legend');
            var legend_table = document.createElement('table');
            legend.appendChild(legend_table);
            for (var key in categoryArray) {
                var tr = document.createElement('tr');
                var td1 =document.createElement('td');
                var td2 = document.createElement('td');
                td1.innerHTML = shortCategoryArray[key];
                td2.innerHTML = categoryArray[key];
                tr.appendChild(td1);
                tr.appendChild(td2);
                legend_table.appendChild(tr);

            }
            var tr1 = document.createElement('tr');
            var td1_1 =document.createElement('td');
            var td1_2 = document.createElement('td');
            td1_1.style.background="#666666";
            td1_2.innerHTML = "This color means hidden";
            tr1.appendChild(td1_1);
            tr1.appendChild(td1_2);
            legend_table.appendChild(tr1);
            var tr2 = document.createElement('tr');
            var td2_1 =document.createElement('td');
            var td2_2 = document.createElement('td');
            td2_1.style.border="1px solid black";
            td2_2.innerHTML = "This color means display";
            tr2.appendChild(td2_1);
            tr2.appendChild(td2_2);
            legend_table.appendChild(tr2);
            map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(legend);


            /*Here is the filter window*/
            function buttonChange(btnState, id){
                if (btnState==true) {
                // marker1.setMap(map);
                    document.getElementById(id).style.background="#666666";
                    setMapOnMark(null,id);

                }
                if (btnState==false) {
                // marker.setMap(null);
                    document.getElementById(id).style.background="#ffffff";
                    setMapOnMark(map,id);
                }
            }

            function changeBtnState(){
                if (this.state === undefined){
                    this.state = false;
                }
                state = this.state;
                if (state == true){
                    state = false;
                }else {
                    state = true;
                }
                this.state=state;
                id = this.id;
                return (buttonChange(state,id));
            }

            function setMapOnMark(state, id) {
                // showAllMarks();
                for (var i = 0; i < markerArray.length; i++) {
                    if (markerArray[i].getLabel().text==id) {
                        markerArray[i].setMap(state);
                    }
                }
            }

            function showAllMarks(){
                for (var i =0; i<markerArray.length;i++){
                    markerArray[i].setMap(map);
                }
            }

            function hideAllMarks(){
                for (var i =0; i<markerArray.length;i++){
                    markerArray[i].setMap(null);
                }
            }

            var filter = document.getElementById('filter');
            for (key in categoryArray) {
                var btn = document.createElement('button');
                btn.innerHTML = shortCategoryArray[key];
                btn.id = shortCategoryArray[key];
                btn.onclick = changeBtnState;
                filter.appendChild(btn);
            }

            var slist = '<?php echo urlencode(json_encode($relationshipArray));?>';
            var list = eval(decodeURIComponent(slist));



            map.controls[google.maps.ControlPosition.TOP_LEFT].push(filter);

            
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


                    markerArray.push(marker<?php echo $count ?>);
                    var contentString<?php echo $count?> =
                    '<div id = "companyInfo<?php echo $count?>">'
                        +'<p>Company: <?php echo $sc->getId() ?></p>'
                        +'<p>Company: <?php echo $sc->getName() ?></p>'
                        +'<img src=\'<?php echo $sc->getImage() ?>\' class=\'logo\'>'
                        +'<br>'
                        +'<p><?php echo htmlentities($sc->getDescription(), ENT_QUOTES)?></p>'
                        +'<a href=\'<?php echo $sc->getUrl()?>\'>Link</a><br>'
                        //+'<button id="showRe<?php //echo $count?>//" onclick=\'showRe(32)\'>Show Re</button><br>'
                        //+'<form action="" method="post"><input type="hidden" value="<?php //echo $count?>//" name="comId"><input type="hidden" value="1" name="checkRe"><button>show</button></form>'
                     +'</div>';
                    var lineSymbol = {
                        path: google.maps.SymbolPath.FORWARD_CLOSED_ARROW
                    };
                    marker<?php echo $count?>.addListener('click', function() {
                        infoWindow.setContent(contentString<?php echo $count ?>);
                        infoWindow.open(map, marker<?php echo $count ?>);

                        var companyInfo<?php echo $count?> = document.getElementById('companyInfo<?php echo $count?>');
                        var btnShowRe = document.createElement('button');
                        //var btnShowRe = document.getElementById('showRe<?php //echo $count?>//');
                        btnShowRe.innerHTML = "Show Re";
                        btnShowRe.id = "showRe<?php echo $count?>";
                        btnShowRe.onclick = function (){
                            hideAllMarks();
                            var id = <?php echo $count?>-1;
                            // console.log(list[id]);
                            for(i in lineArray){
                                lineArray[i].setMap(null);
                            }
                            for(i in list[id]){
                                markerArray[list[id][i][0]-1].setMap(map);
                                markerArray[list[id][i][1]-1].setMap(map);
                                var line = new google.maps.Polyline({
                                    path: [markerArray[list[id][i][0]-1].getPosition(), markerArray[list[id][i][1]-1].getPosition()],
                                    icons: [{
                                        icon: lineSymbol,
                                        offset: '100%'
                                    }],
                                    map: map
                                });
                                line.setMap(map);
                                lineArray.push(line);

                            }


                        };
                        companyInfo<?php echo $count?>.appendChild(btnShowRe);
                        //var btnShowRe = document.getElementById('showRe<?php //echo $count?>//');

                    });
                    map.addListener('click', function() {
                        infoWindow.close();
                    });



            <?php

                }

            }

            ?>
            function showRe(id) {
                // hideAllMarks();
                // buttonChange(false, id)

                alert(this.object);
            }


            //console.log(list);

        }

    </script>

    </body>
</html>