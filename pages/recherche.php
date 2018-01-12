<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RC2 - Recherche de produit et des similitudes</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" type="logo/png" href="../data/logo.png" />
    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/recherches.js"></script>

    <?php
    include("../staticViews/menu.html");
    ?>

</head>
<body>


    <div id="divSearchProducts" class="container">
        </br></br></br></br>
        <h1 class="text-center">Recherche de produits : </h1>
        </br></br>

        <div class="form-group">
            <div class="input-group input-group-lg icon-addon addon-lg list-style:none">
                <input type="text" placeholder="Texte" name="" id="schbox" class="form-control input-lg">
                <i class="icon icon-search"></i>
                <span class="input-group-btn">
              <button id="btnSearch" class="btn btn-inverse">Rechercher</button>
          </span>
            </div>
        </div>
    </div>

    <div id="divTableProducts" class="container" style="display: none">

        <h1 class="text-center">Liste des produits : </h1>
        </br></br>

            <table class="table table-hover table-bordered">

                <thead>
                    <tr>
                        <th></th>
                        <th>Nom</th>
                        <th>Origine</th>
                        <th>Score de nutrition</th>
                        <th>Energies</th>
                        <th>Matières grasses</th>
                        <th>Matières grasses saturées</th>
                        <th>Protéines</th>
                        <th>Sels</th>
                        <th>Sucres</th>
                    </tr>
                </thead>

                <tbody id="bodyTable">



                </tbody>
            </table>
        <p>Page : <a id="curPage"></a> | <a style="cursor: pointer" id="postPage" href="#divTableProducts">Page précédente</a> | <a style="cursor: pointer" id="nextPage" href="#divTableProducts">Page Suivante</a></p>
    </div>

    <div id="divInfo" style="display: none">
        <h1 class="text-center">Informations sur le produit : </h1>

        <div id="divInfoProduct" class="container">

            <img style="display: block; margin: 0 auto" id="p_img" width="150" height="150">
            <br>
            <p style="text-align: center">
                Nom : <a id="p_nom"></a><br>
                Origine : <a id="p_origine"></a><br>
                Score de nutrition : <a id="p_nutr"></a><br>
                Energies : <a id="p_nrj"></a><br>
                Matières grasses : <a id="p_fat"></a><br>
                Matières grasses saturées : <a id="p_satfat"></a><br>
                Protéines : <a id="p_prot"></a><br>
                Sels : <a id="p_salt"></a><br>
                Sucres : <a id="p_sugar"></a><br>
            </p>
        </div>
    </div>

    <div id="divSimi" style="width: 100%; display: none">

        <h1 class="text-center">Produits similaires : </h1>
        </br></br>

        <div id="divSimiProducts" style="padding: 0 0; width: 80%; margin: 0 auto;">



        </div>
    </div>
  <?php
    include("../staticViews/footer.html");
  ?>
</body>