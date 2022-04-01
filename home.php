<?php
// Dependencies
require './include/config.php';
require './include/include.php';

// Start Session
session_start();

if(!isset($_SESSION['access_token'])){
    error_log("landing.php: No Access Token");
    header("Location: /");
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

$scopes = explode(' ',$resultObj->scope);

$logoutUrl = "https://auth.circle.army/oauth2/sessions/logout?id_token_hint=".$_SESSION['id_token']."&post_logout_redirect_uri=".urlencode('https://www.circle.army/logout.php');

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

    <title>Circle.Army - User Home</title>

  </head>
  <body class="bg-dark text-light">

    <?php
    include 'include/nav_bar.php';
    ?>

    <main class="main bg-dark text-light">
        <div class="px-4 py-5 my-5 text-center">
            <i class="fa-solid fa-users fa-10x"></i>
            <h1 class="display-5 fw-bold">Welcome</h1>
            <h2><?php echo $resultObj->sub; ?></h2>
            <div class="col-lg-6 mx-auto">
            <p class="lead mb-4">This is your user page, it's under construction</p>
            <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
            <button type="button" class="btn disabled btn-outline-secondary btn-lg px-4">More Coming Soon</button>
            </div>
            <br><br>
            <p class="lead">Your /userinfo:</p>
            <p class="lead"><?php printf(json_encode($resultObj)); ?></p>
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

    <!--Web3 Stuff-->
    <script src="https://cdn.jsdelivr.net/npm/web3@latest/dist/web3.min.js"></script>

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
        $('#footer-insert-right').html('<a class="link-light" href="<?php echo $logoutUrl; ?>">Log Out</a>');
    </script>

    <!-- Landing App -->
    <script src="js/landingApp.js"></script>


  </body>
</html>





<?php




?>