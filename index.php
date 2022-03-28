<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="css/custom.css" rel="stylesheet">

    <title>Circle.Army</title>

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
            <p class="lead mb-4">Fighting for your right to a public domain</p>
            <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
            <button type="button" class="btn disabled btn-outline-secondary btn-lg px-4">Coming Soon</button>
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
