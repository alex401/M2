<?php
    //include("login/isEnSession.php");
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

    <link href="components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="components/jquery/dist/jquery.min.js"></script>
    <script src="components/tether/dist/js/tether.min.js"></script>
    <script src="components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="components/angular/dist/angular.js"></script>
    <script src="components/angular-bootstrap/dist/ui-bootstrap.min.js"></script>
    <script src="components/angular-ui-router/dist/angular-ui-router.js"></script>
    <script src="js/dashboard.min.js"></script>

    <!-- Custom styles for this template -->
    <link href="css/starter-template.css" rel="stylesheet">
  </head>

  <body ng-controller="MasterCtrl">

    <nav class="navbar navbar-toggleable-md navbar-inverse bg-inverse fixed-top">
      <button class=" d-none d-lg-block navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <a class="navbar-brand" href="#"><img src="logo-m2.png" alt="Navigation"></a>

      <div class="collapse navbar-collapse d-none d-lg-block" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">

           <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#/menu/commandes" id="dropdown01"  aria-haspopup="true" aria-expanded="false">Commande</a>
           </li>

          <li class="nav-item active">
               <a class="nav-link" href="#/admin/recherchetiers">Recherche tiers <span class="sr-only">(current)</span></a>
          </li>

          <li class="nav-item active">
               <a class="nav-link" href="#/admin/recherchetags">Recherche contacts <span class="sr-only">(current)</span></a>
          </li>


        </li>

        </ul>
      </div>
    </nav>


  <div ui-view></div>


  </body>
</html>
