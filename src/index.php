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
    <script src="components/angular-cookies/dist/angular-cookies.min.js"></script>
    <script src="components/angular-sanitize-168/dist/angular-sanitize.min.js"></script>
    <script src="components/angular-bootstrap/dist/ui-bootstrap-tpls.min.js"></script>
    <script src="components/angular-ui-router/dist/angular-ui-router.js"></script>
    <script src="components/angular-translate/dist/angular-translate.min.js"></script>
    <script src="components/angular-translate/dist/angular-translate-storage-cookie/angular-translate-storage-cookie.min.js"></script>
    <script src="components/angular-translate/dist/angular-translate-storage-local/angular-translate-storage-local.min.js"></script>
    <script src="components/angular-translate/dist/angular-translate-loader-static-files/angular-translate-loader-static-files.min.js"></script>
    <script src="js/dashboard.min.js"></script>

    <!-- Custom styles for this template -->
    <link href="css/starter-template.css" rel="stylesheet">
  </head>

  <body ng-controller="MasterCtrl">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">

      <a class="navbar-brand" href="#"><img src="logo-m2.png" alt="Navigation"></a>

      <div class="collapse navbar-collapse d-none d-lg-block" id="navbarsExampleDefault">
        <div class="navbar-nav mr-auto">

          <?php if ($_SESSION["usertype_utilisateurformulaires"] == "user" || $_SESSION["usertype_utilisateurformulaires"] == "admin") : ?>

            <div class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="commandsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{'navbar.command' | translate}}</a>
                <div class="dropdown-menu" aria-labelledby="commandsDropdown">
                  <a class="dropdown-item" href="#/commande/repas">{{'menu.commands.meal' | translate}}</a>
                  <a class="dropdown-item" href="#/commande/materiel">{{'menu.commands.material' | translate}}</a>
                  <a class="dropdown-item" href="#/commande/carburant">{{'menu.commands.fuel' | translate}}</a>
                  <a class="dropdown-item" href="#/commande/transport">{{'menu.commands.transport' | translate}}</a>
                </div>
              </div>

          <div class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{'navbar.search' | translate}}</a>
              <div class="dropdown-menu" aria-labelledby="searchDropdown">
              <a class="dropdown-item" href="#/admin/recherchetiers">{{'recherche.tiers.title' | translate}}</a>
              <a class="dropdown-item" href="#/admin/recherchetags">{{'recherche.tags.title' | translate}}</a>
              <a class="dropdown-item" href="#/admin/recherchecontacts">{{'recherche.contact.title' | translate}}</a>
            </div>
          </div>
        <?php endif; ?>


          <?php if ($_SESSION["usertype_utilisateurformulaires"] == "admin") : ?>
          <div class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{'navbar.admin' | translate}}</a>
            <div class="dropdown-menu" aria-labelledby="adminDropdown">
              <a class="dropdown-item" href="#/superadmin/warnings">{{'navbar.superadmin.messages' | translate}}</a>
              <a class="dropdown-item" href="#/superadmin/logins">{{'navbar.superadmin.logins' | translate}}</a>
              <a class="dropdown-item" href="#/superadmin/mails">{{'navbar.superadmin.attribution' | translate}}</a>
              <a class="dropdown-item" href="#/superadmin/params">{{'navbar.superadmin.parametres' | translate}}</a>
            </div>
          </div>
          <?php endif; ?>
        </div>

        <div class="navbar-nav">
          <div class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="langDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{'navbar.language' | translate}}</a>
            <div class="dropdown-menu" aria-labelledby="adminDropdown">
              <button class="dropdown-item" ng-click="changeLanguage('fr')">FR</button>
              <button class="dropdown-item" ng-click="changeLanguage('de')">DE</button>
            </div>
          </div>
          <a class="nav-item nav-link" href="login/logout.php">Logout</a>
        </div>

      </div>
    </nav>

    <div ui-view></div>

  </body>
</html>
