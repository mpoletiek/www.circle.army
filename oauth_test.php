<?php

# Include Dependencies
require './include/config.php';
require './include/include.php';
require './include/oauth.php';

function headersToArray( $str )
{
    $headers = array();
    $headersTmpArray = explode( "\r\n" , $str );
    for ( $i = 0 ; $i < count( $headersTmpArray ) ; ++$i )
    {
        // we dont care about the two \r\n lines at the end of the headers
        if ( strlen( $headersTmpArray[$i] ) > 0 )
        {
            // the headers start with HTTP status codes, which do not contain a colon so we can filter them out too
            if ( strpos( $headersTmpArray[$i] , ":" ) )
            {
                $headerName = substr( $headersTmpArray[$i] , 0 , strpos( $headersTmpArray[$i] , ":" ) );
                $headerValue = substr( $headersTmpArray[$i] , strpos( $headersTmpArray[$i] , ":" )+1 );
                $headers[$headerName] = $headerValue;
            }
        }
    }
    return $headers;
}

# Start New User Session
session_start();

// Get Auth URL
$oauthURL = getOAuthURL($OAUTH2_ENDPOINT,'auth');
echo "OAuth URL: ".$oauthURL."<br>";


$nonce = generateNonce(64);
$_SESSION['nonce'] = $nonce;
$token = generateNonce(64);
$hashed_token = hash('sha512',$token);
$_SESSION['token'] = $hashed_token;
$state=$token;

// Setup Client Credentials Grant
$combinedURL = $oauthURL."?response_type=code&client_id=auth-client0&redirect_uri=".urlencode($redirect_uri)."&nonce=".urlencode($nonce)."&state=".urlencode($state);
//echo "<br>next URL: ".$combinedURL."<br>";

echo "<a href=\"".$combinedURL."\">Sign In</a>";

//echo "<pre>";
//var_dump($_SERVER);
//echo "</pre>";


?>