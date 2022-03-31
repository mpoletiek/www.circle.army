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


?>




<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="css/custom.css" rel="stylesheet">

    <title>Circle.Army - Log In</title>

  </head>
  <body class="bg-dark text-light">

    <?php
    include 'include/nav_bar.php';
    ?>

    <main class="main bg-dark text-light">
        <div class="px-4 py-5 my-5 text-center">
            <i class="fa-solid fa-users fa-10x"></i>
            <h1 class="display-5 fw-bold">Circle.Army</h1>
            <div class="col-lg-6 mx-auto">
            <p class="lead mb-4">Web3 Wallet Required</p>
            <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
            <button type="button" class="btn btn-outline-secondary btn-lg px-4" onclick="window.location.href='<?php echo $combinedURL; ?>';">Log In</button>
            </div>
            </div>
        </div>
    
    
    </main>

    <?php
    include 'include/footer.php';
    ?>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="js/navbar.js"></script>
    <script>
        setMenuItem("m_home");
    </script>

  </body>
</html>
