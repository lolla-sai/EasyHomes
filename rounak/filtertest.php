<?php
    require '../components/runSQLQuery.php';
    function set_alert($a, $b) {
        echo $a."<br>";
    }
    $conn = mysqli_connect("localhost", "root", "", "easyhomes", 3306);
    if($conn->connect_error) {
        set_alert("Database Connection Failed", "danger");
        goto endpoint;
    }
    // sql_query($conn, "");
    // 1deg = 69km
    endpoint:
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testing Filters</title>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBimqJizKom7LcizcvUdr-BGGq8dHEtCbE"></script>

    <script>
        let coords = [];
        var position = [15.496596, 73.835353];
    </script>

    <?php
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $lat = floatval($_POST['latitude']);
            $lng = floatval($_POST['longitude']);
            echo "<script>var position = [$lat, $lng];</script>";
            $lat_limits = [$lat-0.005, $lat+0.005];
            $lng_limits = [$lng-0.005, $lng+0.005];
            // var_dump($lat_limits);
            echo "SELECT * from property WHERE (latitude BETWEEN " . implode(' AND ', $lat_limits) . ") AND (longitude BETWEEN " . implode(' AND ', $lng_limits) . ")";
            $output = sql_query($conn, "SELECT * from property WHERE (latitude BETWEEN " . implode(' AND ', $lat_limits) . ") AND (longitude BETWEEN " . implode(' AND ', $lng_limits) . ")");
            // print_r($output);
            while($row = $output->fetch_assoc()) {
                // echo $row['property_id'] . '<br>';
                $id = $row['property_id'];
                $row_lat = $row['latitude'];
                $row_lng = $row['longitude'];
                echo "<script>coords.push([$row_lat, $row_lng, '$id'])</script>";
                // echo "<script>placeMarker($row_lat, $row_lng, '$id', map)</script>";
            }
        }
    ?>

    <script>
        function initialize() { 
            var latlng = new google.maps.LatLng(position[0], position[1]);

            const svgMarker = {
                path: "M10.453 14.016l6.563-6.609-1.406-1.406-5.156 5.203-2.063-2.109-1.406 1.406zM12 2.016q2.906 0 4.945 2.039t2.039 4.945q0 1.453-0.727 3.328t-1.758 3.516-2.039 3.070-1.711 2.273l-0.75 0.797q-0.281-0.328-0.75-0.867t-1.688-2.156-2.133-3.141-1.664-3.445-0.75-3.375q0-2.906 2.039-4.945t4.945-2.039z",
                fillColor: "blue",
                fillOpacity: 0.6,
                strokeWeight: 0,
                rotation: 0,
                scale: 2,
                anchor: new google.maps.Point(15, 30),
            };

            var myOptions = {
                zoom: 16,
                center: latlng,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            map = new google.maps.Map(document.getElementById("mapCanvas"), myOptions);
            marker = new google.maps.Marker({
                position: latlng,
                map: map,
                title: "Latitude:"+position[0]+" | Longitude:"+position[1]
            });
            
            console.log(coords);
            coords.forEach(coordinate => {
                let latlng = new google.maps.LatLng(coordinate[0], coordinate[1]);
                let marker = new google.maps.Marker({
                    position: latlng,
                    map: map,
                    title: "Property ID: " + coordinate[2],
                    icon: svgMarker
                });
            })
        
        
            google.maps.event.addListener(map, 'click', function(event) {
                var result = [event.latLng.lat(), event.latLng.lng()];
                transition(result);
            });
        }
        
        //Load google map
        google.maps.event.addDomListener(window, 'load', initialize);
        
        
        var numDeltas = 100;
        var delay = 10; //milliseconds
        var i = 0;
        var deltaLat;
        var deltaLng;
        
        function transition(result){
            i = 0;
            deltaLat = (result[0] - position[0])/numDeltas;
            deltaLng = (result[1] - position[1])/numDeltas;
            moveMarker();
        }

        function moveMarker(){
            position[0] += deltaLat;
            position[1] += deltaLng;
            var latlng = new google.maps.LatLng(position[0], position[1]);
            marker.setTitle("Latitude:"+position[0]+" | Longitude:"+position[1]);
            marker.setPosition(latlng);
            document.querySelector("#latitude").value=position[0];
            document.querySelector("#longitude").value=position[1];
            if(i!=numDeltas){
                i++;
                setTimeout(moveMarker, delay);
            }
        }
    </script>
    <style>
        #mapCanvas{
            height: 500px;
        }
    </style>

    <style>
        #mapCanvas {
            width: 500px;
            height: 500px;
            margin: 2rem;
        }
    </style>
    <!-- <script>
        function placeMarker(lat, lng, title, map) {
            let latlng = new google.maps.LatLng(lat, lng);
            let marker = new google.maps.Marker({
                position: latlng,
                map: map,
                title: title
            });
        }
    </script> -->
</head>
<body>
    <form action="#" method="POST">
        <div class="input-group mb-3">
            <label for="latitude" class="input-group-text">Latitude</label>
            <input type="text" id="latitude" name="latitude" class="form-control" placeholder="Search for a nearby place or landmark">
            <label for="longitude" class="input-group-text">Longitude</label>
            <input type="text" id="longitude" name="longitude" class="form-control" placeholder="Search for a nearby place or landmark">
        </div>
        <div id="mapCanvas"></div>
        <input type="submit" value="Submit">
    </form>
    <?php
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            mysqli_data_seek($output, 0);
            while($row = $output->fetch_assoc()) {
                echo $row['property_id'] . '<br>';
                $id = $row['property_id'];
                $row_lat = $row['latitude'];
                $row_lng = $row['longitude'];
                echo "<script>placeMarker($row_lat, $row_lng, '$id', map)</script>";
            }
        }
    ?>
</body>
</html>