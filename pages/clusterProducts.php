<head>
    <meta charset="utf-8">
    <title>RC2 - cluster du guide d’alimentation assisté par le data mining</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" type="logo/png" href="../data/logo.png" />
    <script src="../js/jquery.js"></script>
    <script src="../js/clusterProducts.js"></script>
    <script src="../js/bootstrap.min.js"></script>

</head>
<body>
  <nav  class="navbar navbar-default navbar-fixed-top">
    <?php
      include("../staticViews/menu.html");
    ?>
  </nav>
    <div class="row text-center">
    </br></br></br></br></br><h1>10 produits autour des centroïds</h1>
    </br><img src="../data/productsneartocentroid.png" alt="graphe">

    <div id="divTableProducts" class="container">

        <h1 class="text-center">Liste des produits par centroïds : </h1>
        </br></br>

        <table class="table table-hover table-bordered">

            <thead>
            <tr>
                <th></th>
                <th>Centroïd 1</th>
                <th>Centroïd 2</th>
                <th>Centroïd 3</th>
                <th>Centroïd 4</th>
                <th>Centroïd 5</th>
                <th>Centroïd 6</th>
            </tr>
            </thead>

            <tbody id="bodyTable">

            </tbody>
        </table>
    </div>

    </div>
      <?php
        include("../staticViews/footer.html");
      ?>
</body>
