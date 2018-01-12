<?php
	/*connectBD();*/
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>RC2 - Guide d’alimentation assisté par le data mining</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
        <link rel="icon" type="logo/png" href="data/logo.png" />
        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.bundle.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
    </head>

    <body class="body">
      <?php
         include("staticViews/menu.html");
         include("staticViews/head.html");
      ?>
          <div class="mainContent">
              <div class="Content">
                  <?php
                      $nomPage = './pages/accueil.php'; // page par défaut
                      if(isset($_GET['page']))
                      {
                          $_GET['page'] = addslashes($_GET['page']);
                          $_GET['page'] = 'pages/'.$_GET['page'].'.php';
                          if(file_exists($_GET['page']) &&
                              $_GET['page'] != 'index.php')
                              $nomPage = $_GET['page'];
                      }
                      include($nomPage);
                  ?>
              </div>
          </div>
        <footer class="footer">
            <?php
                include("./staticViews/footer.html");
            ?>
        </footer>
    </body>
</html>
<?php
/*deconnectBD();*/
?>
