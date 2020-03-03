<?php

session_start();

if (!isset($_SESSION["login_utilisateurformulaires"]))
{
    header("Location:login/index.php");
    exit();
}

?>
