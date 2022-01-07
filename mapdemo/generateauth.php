<?php
    function httpPost($url, $data)
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_FAILONERROR, true); // Required for HTTP error codes to be reported via our call to curl_error($ch)
        $response = curl_exec($curl);
        if (curl_errno($curl)) {
            echo curl_error($curl);
        }
        curl_close($curl);
        return $response;
    }

    function getToken() {
        $url = "https://outpost.mapmyindia.com/api/security/oauth/token";
        $fields = [
            'client_secret' => "lrFxI-iSEg-JldSr7mZra6qo7FYYUBo-syPeHMnGoQ67GzzbSOACjlMJaH2hrXKJioCoGYUxGBNXQ1Ngd1FgImP5QVGag-to",
            'grant_type' => "client_credentials",
            'client_id' => "33OkryzDZsLrMVolv_QN_K4RwlKG3uIH8r6M_AYPYm4Uhm0dU2cSxfDp6MiGwMh3BX9eElBbBePwIJ7oK9nElw=="
        ];
        $output = httpPost($url, $fields);
        $jsonoutput = json_decode($output, true);
        return $jsonoutput['access_token'];
    }
?>