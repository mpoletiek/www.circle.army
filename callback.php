<?php
// Dependencies
require './include/config.php';
require './include/include.php';

// Start Session
session_start();

// Check for session variables
if(!isset($_SESSION['token']) || !isset($_SESSION['nonce'])){
    error_log("callback.php: Improper Session");
    exit();
}
// Get new variables
if(isset($_GET['state']) && isset($_GET['code'])){
    error_log("callback.php: state: ".$_GET['state']);
    error_log("callback.php: code: ".$_GET['code']);
}
// Check session validity
$hashed_state = hash('sha512',$_GET['state']);
if($hashed_state == $_SESSION['token']){
    error_log("callback.php: Session Matched");
}
else{
    error_log("callback.php: No Session Match");
    exit();
}

// exchange code for token
$url = $OAUTH2_ENDPOINT."oauth2/token";
$crl = curl_init($url);
curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($crl, CURLINFO_HEADER_OUT, true);
curl_setopt($crl, CURLOPT_POST, true);
curl_setopt($crl, CURLOPT_POSTFIELDS,"client_id=".$CLIENTID."&code=".$_GET['code']."&grant_type=authorization_code");
// Set HTTP Header for POST request 
curl_setopt($crl, CURLOPT_HTTPHEADER, array(
    //'Content-Type: application/json'
    'Authorization: Basic '. base64_encode($CLIENTID.':'.$CLIENTSECRET)
));

// Submit the POST request
try{
    $result = curl_exec($crl);
    var_dump($result);
    $status_code = curl_getinfo($crl, CURLINFO_HTTP_CODE);   //get status code
    //var_dump($status_code);
}
catch (exception $e){
var_dump($e);
}

// Decode Results
$resultObj = json_decode($result);
if(!isset($resultObj->access_token)){
    error_log("callback.php: No Access Token Returned");
}
$accessToken = $resultObj->access_token;
error_log("callback.php: Access Token Acquired");
curl_close($crl);

// Get user info with access token
$url = $OAUTH2_ENDPOINT."userinfo";
$crl = curl_init($url);
curl_setopt($crl,CURLOPT_RETURNTRANSFER,true);
curl_setopt($crl,CURLINFO_HEADER_OUT,true);
//curl_setopt($crl,CURLOPT_POST,true)
curl_setopt($crl,CURLOPT_HTTPHEADER,array(
    'Authorization: Bearer '.$accessToken
));
try{
    $result = curl_exec($crl);
    echo "<pre>";
    var_dump($result);
    echo "</pre>";

    $status_code = curl_getinfo($crl, CURLINFO_HTTP_CODE);   //get status code
    //var_dump($status_code);
}
catch (exception $e){
var_dump($e);
}

// Decode Result
$resultObj = json_decode($result);
if(!isset($resultObj->sub)){
    error_log("callback.php: Failed to get openid userinfo");
    exit();
}

echo "<h1>".$resultObj->sub." Logged In</h1>";
$_SESSION['access_token'] = $accessToken;

header("Location: /landing.php?state=".$_GET['state']);

/*
if($_GET['nonce'] == $_SESSION['nonce']){
    echo "<br>";
    echo "Nonce Matched<br>";
    //$challenge = hash('sha256',)
    // get token
    $pattern="/token=(.*)/";
    preg_match($pattern,$_GET['state'],$matches);
    $challenge = hash('sha512',$matches[1]);
    echo "Challenge: ".$challenge."<br>";
    if($challenge == $_SESSION['hashed_secret']){
        echo "<br>Session Secured<br>";



    }
    else{
        echo "<br>Session Mismatch<br>";
    }
}
else{
    echo "<br>";
    echo "Nonce Mismatch";
}

*/

?>