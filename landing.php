<?php
// Dependencies
require './include/config.php';
require './include/include.php';

// Start Session
session_start();

echo "<pre>";
var_dump($_SESSION);
echo "</pre>";

echo "<br>State: ".$_GET['state'];

$hashed_state = hash('sha512',$_GET['state']);
if($hashed_state == $_SESSION['token']){
    error_log("landing.php: Session Match");
}

// check auth token
$url = $OAUTH2_ENDPOINT."userinfo";
$crl = curl_init($url);
curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($crl,CURLINFO_HEADER_OUT,true);
//curl_setopt($crl,CURLOPT_POST,true)
curl_setopt($crl,CURLOPT_HTTPHEADER,array(
    'Authorization: Bearer '.$_SESSION['access_token']
));
try{
    $result = curl_exec($crl);
    echo "<pre>";
    var_dump($result);
    echo "</pre>";
}
catch (exception $e){
    var_dump($e);
}


?>