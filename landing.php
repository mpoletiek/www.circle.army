<?php
// Dependencies
require './include/config.php';
require './include/include.php';

// Start Session
session_start();

$hashed_state = hash('sha512',$_GET['state']);
if($hashed_state == $_SESSION['token']){
    error_log("landing.php: Session Match");
}
else{
    echo "<h3>Valid Session</h3>";
}

if(!isset($_SESSION['access_token'])){
    error_log("landing.php: No Access Token");
}
//echo "<h3>Acquired Access Token</h3>";

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
}
catch (exception $e){
    var_dump($e);
}
// Decode result
$resultObj = json_decode($result);
if(!isset($resultObj->provider)){
    error_log("landing.php: Invalid Access Token");
    exit();
}
echo "<h3>".$resultObj->sub." Logged In</h3>";

$scopes = explode(' ',$resultObj->scope);

foreach($scopes as $scope){
    echo "<h4>Scope: ".$scope."</h4>";
}




$logoutUrl = "https://auth.circle.army/oauth2/sessions/logout?id_token_hint=".$_SESSION['id_token']."&post_logout_redirect_uri=".urlencode('https://www.circle.army/logout.php');
//$logoutUrl = "https://auth.circle.army/oauth2/sessions/logout?id_token_hint=".urlencode($_SESSION['access_token'])."&post_logout_redirect_uri=".urlencode('https://www.circle.army/logout.php');

?>




<br>
<a href="<?php echo $logoutUrl; ?>">Log Out</a>
<pre>
    <?php var_dump($_SESSION); ?>
</pre>

<?php




?>