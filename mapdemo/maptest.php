<html>
    <head>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBimqJizKom7LcizcvUdr-BGGq8dHEtCbE"></script>
        <script>
            var position = [15.496596, 73.835353];
            
            function initialize() { 
                var latlng = new google.maps.LatLng(position[0], position[1]);
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
                if(i!=numDeltas){
                    i++;
                    setTimeout(moveMarker, delay);
                }
            }

            function save()
            {
               la=position[0];
               lo=position[1]; 
            }
            </script>
            <style>
                #mapCanvas{
                            width: 100%;
                            height: 400px;
                        }
            </style>
    </head>
    <body>
        <div id="mapCanvas"></div>
        <!-- <form action="" method="POST">
            <input type="submit" value="submit" name="submit" >
        </form> -->
        <button onclick="alert(position[0])">
            Submit
        </button>
    </body>
</html>
<?php
    if(isset($_POST['submit']))
    {
        
    }
    $num="<script>document.write(la)</script>";
        echo $num;

?>