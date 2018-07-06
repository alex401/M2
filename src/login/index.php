<?php
require("config.php");
$back="";
$logout="";
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

		<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
		<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>


    <!-- Custom styles for this template -->
    <link href="css/starter-template.css" rel="stylesheet">
  </head>


<form method="post" action="controle_login.php">

	<div class="container">
    <div class="row">
        <div class="col-sm-12 col-12 ">
            <div style="text-align:center;" class="account-wall">
                <img  class="profile-img" src="../logo-m2-login.png"
                    alt="">
                <form class="form-signin">
                <input  type="text" name="login" id='login' class="form-control" placeholder="login" required autofocus> <br>
                <input type="password" name="motdepasse" id='motdepasse'  class="form-control" placeholder="Password" required> <br>
                <button class="btn btn-lg btn-primary btn-block" type="submit">
                    Connection</button>

                </form>
            </div>
        </div>
    </div>
</div>



</form>

<?php
$erreur = addslashes(htmlspecialchars(isset($_GET['erreur']) ? $_GET['erreur'] : ''));
if ($erreur == 1) {
    print "Login et / ou mot de passe erroné(s).";
}
?>
