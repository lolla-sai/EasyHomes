<script>
    let i = {
        "access_token": "051e14e6-7e1b-49ee-a7b7-fb705c517519",
        "token_type": "bearer",
        "expires_in": 86399,
        "scope": "READ",
        "project_code": "prj1637733218i761503775",
        "client_id": "33OkryzDZsLrMVolv_QN_K4RwlKG3uIH8r6M_AYPYm4Uhm0dU2cSxfDp6MiGwMh3BX9eElBbBePwIJ7oK9nElw=="
    }
</script>
<?php
    function getToken() {
        $url = "https://outpost.mapmyindia.com/api/security/oauth/token";
        $client_secret = "lrFxI-iSEg-JldSr7mZra6qo7FYYUBo-syPeHMnGoQ67GzzbSOACjlMJaH2hrXKJioCoGYUxGBNXQ1Ngd1FgImP5QVGag-to";
        $client_id = "33OkryzDZsLrMVolv_QN_K4RwlKG3uIH8r6M_AYPYm4Uhm0dU2cSxfDp6MiGwMh3BX9eElBbBePwIJ7oK9nElw==";
        $grant_type = "client_credentials";
        //The url you wish to send the POST request to

        //The data you want to send via POST
        $fields = [
            'client_secret' => $client_secret,
            'grant_type' => $grant_type,
            'client_id' => $client_id
        ];
        
        //url-ify the data for the POST
        $fields_string = http_build_query($fields);
        
        //open connection
        $ch = curl_init();
        
        //set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
        
        //So that curl_exec returns the contents of the cURL; rather than echoing it
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 
        if (curl_errno($ch)) {
            echo curl_error($ch);
        }
        
        //execute post
        $result = curl_exec($ch);
        curl_close ($ch);
        return $result;
    }
    echo(getToken());

    $token_type = 'bearer';
    $token = '051e14e6-7e1b-49ee-a7b7-fb705c517519';
    function getRequest($url, $headers) {
        global $token, $token_type;
        $ch = curl_init($url);
        curl_setopt($ch,CURLOPT_POST, 0);                //0 for a get request
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT ,3);
        curl_setopt($ch,CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_FAILONERROR, true); // Required for HTTP error codes to be reported via our call to curl_error($ch)
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            echo curl_error($ch);
        }
        // if($response)
        //     echo "curl response is:" . $response;
        curl_close ($ch);
        return $response;
    }
    
    $response1 = getRequest("https://apis.mapmyindia.com/advancedmaps/v1/$token/map_load?v=1.3", array(
            "Authorization: $token_type $token"
        ));
    $response2 = getRequest("https://apis.mapmyindia.com/advancedmaps/api/$token/map_sdk_plugins", array(
            "Authorization: $token_type $token"
        ));
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
             