<?php
    include("login/isEnSession.php");
?>


<!DOCTYPE html>

<html lang="en" ng-app="PCIM2">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>M2 - PCI 2.0</title>

    <!-- Bootstrap core CSS -->
    <link href="components/bootstrap4.4.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="components/jquery/dist/jquery.min.js"></script>
    <script src="components/mustache/dist/mustache.min.js"></script>
    <script src="components/tether/dist/js/tether.min.js"></script>
    <script src="components/bootstrap4.4.1/dist/js/bootstrap.min.js"></script>
    <script src="components/angular/dist/angular.js"></script>
    <script src="components/angular-bootstrap/dist/ui-bootstrap-tpls.min.js"></script>
    <script src="components/angular-ui-router/dist/angular-ui-router.js"></script>
    <script src="js/dashboard.min.js"></script>

    <!-- Custom styles for this template -->
    <link href="css/starter-template.css" rel="stylesheet">
  </head>

  <body ng-controller="MasterCtrl">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">

      <a class="navbar-brand" href="#"><img src="logo-m2.png" alt="Navigation"></a>

      <div class="collapse navbar-collapse d-none d-lg-block" id="navbarsExampleDefault">
        <div class="navbar-nav mr-auto">
          <div class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="commandsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Commande</a>
            <div class="dropdown-menu" aria-labelledby="commandsDropdown">
              <a class="dropdown-item" href="#/commande/repas">Repas</a>
              <a class="dropdown-item" href="#/commande/materiel">Materiel</a>
              <a class="dropdown-item" href="#/commande/carburant">Carburant</a>
              <a class="dropdown-item" href="#/commande/transport">Transport</a>
            </div>
          </div>

          <a class="nav-item nav-link" href="#/admin/recherchetiers">Recherche tiers<span class="sr-only">(current)</span></a>
          <a class="nav-item nav-link" href="#/admin/recherchetags">Recherche contacts<span class="sr-only">(current)</span></a>

          <?php if ($_SESSION["usertype_utilisateurformulaires"] == "admin") : ?>
          <div class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Admin</a>
            <div class="dropdown-menu" aria-labelledby="adminDropdown">
              <a class="dropdown-item" href="#/superadmin/warnings">Avertissements</a>
              <a class="dropdown-item" href="#/superadmin/logins">Logins</a>
            </div>
          </div>
          <?php endif; ?>
        </div>
      </div>
    </nav>

    <div ui-view></div>

  </body>
</html>
