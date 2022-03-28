<?php

# Discover the correct endpoint based off of .well-known/openid-configuration
function getOAuthURL($endpoint,$type){
    
    // Prepare new cURL resource
    $url = $endpoint."/.well-known/openid-configuration";
    $crl = curl_init($url);
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLINFO_HEADER_OUT, true);
    curl_setopt($crl, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json'
    ));
    // Submit the GET request
    try{
        $result = curl_exec($crl);
    }
    catch (exception $e){
        var_dump($e);
    }
    // handle curl error
    if ($result === false) {
        $result_noti = 0; die();
    }
    // Decode result
    $resultObj = json_decode($result);

    // Get endpoint type
    $type_url = "";
    switch ($type) {
        case 'auth':
            $type_url = $resultObj->authorization_endpoint;
            break;
        case 'token':
            $type_url = $resultObj->token_endpoint;
            break;

    }
    // Close cURL session handle
    curl_close($crl);

    //return URL
    return $type_url;
}


?>