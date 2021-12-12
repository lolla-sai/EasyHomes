<?php
    $token_type = 'bearer';
    $token = '0694a439-08ff-4ad5-8fe6-eb90e84f5c8a';
    function getRequest($url) {
        global $token, $token_type;
        $ch = curl_init($url);
        curl_setopt($ch,CURLOPT_POST, 0);                //0 for a get request
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT ,3);
        curl_setopt($ch,CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_FAILONERROR, true); // Required for HTTP error codes to be reported via our call to curl_error($ch)
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Authorization: $token_type $token"
        ));
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            echo curl_error($ch);
        }
        // if($response)
        //     echo "curl response is:" . $response;
        curl_close ($ch);
        return $response;
    }
    
    $response1 = getRequest("https://apis.mapmyindia.com/advancedmaps/v1/$token/map_load?v=1.3");
    $response2 = getRequest("https://apis.mapmyindia.com/advancedmaps/api/$token/map_sdk_plugins");
?>

<html>
 <head>
    <title>MapmyIndia Plugin - Place Picker</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="desciption" content="Mapmyindia Place Picker Plugin">
    <script>
        <?php
            echo $response1;
        ?>
    </script>
    <script>
        <?php
            echo $response2;
        ?>
    </script>
    <!-- <script src="https://apis.mapmyindia.com/advancedmaps/api/<token/jwt key>/map_sdk_plugins"></script> -->

    <!-- <script src="https://apis.mapmyindia.com/advancedmaps/api/0694a439-08ff-4ad5-8fe6-eb90e84f5c8a/map_sdk_plugins"></script> -->
    <!-- <script src="https://apis.mapmyindia.com/advancedmaps/api/{token-OR-JWT-key}/map_sdk_plugins"></script> -->

    <style>
        body{margin: 0}
        #map{
            width: 100%; height: 100vh;margin:0;padding: 0;
        }
       
    </style>
    </head>
    <body>
        <div id="map"></div>
       
        <script>
         /*Map Initialization*/
          var map = new MapmyIndia.Map('map', {center: [28.62, 77.09], zoom: 15, search: false});
          
          /*Place Picker plugin initialization*/
           var options={
                map:map,
                callback:callback_method
               /*
                location:{lat:28.8787,lng:77.08888},//to open that location on map on initailization
                closeBtn:true,
                closeBtn_callback:closeBtn_callback,
                search:true,
                topText:'Location Search',
                pinImage:'pin.png', //custom pin image
                pinHeight:40
                */
            };
            var picker= new MapmyIndia.placePicker(options);
            function callback_method(data) {
                console.log(data);alert(JSON.stringify(data));
                console.log(picker.getLocation());
             }   
             /*methods
              * 
              picker.remove();
              picker.getLocation();
              picker.setLocation({lat:28.8787,lng:77.787877});
              * 
              */
       </script>
    </body>
</html>
             