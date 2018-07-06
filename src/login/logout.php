<?php

require("config.php");

// Fonction permettant de détruire une session
function logout() {
    session_start(); // on démarre la session
    // Pour le fun on supprime une variable de session
    unset($_SESSION["login_utilisateurformulaires"]);
    unset($_SESSION["email_utilisateurformulaires"]);
    unset($_SESSION["nom_utilisateurformulaires"]);
    unset($_SESSION["prenom_utilisateurformulaires"]);

    // maintenant on détruit la session en cours, je vous conseil d'utiliser unset et destroy, ce n'est pas
    // obligatoire, mais plus sécurisé dirons nous.

    session_unset();   // on efface toutes les variables de session
    session_destroy(); // on detruit la session en cours.
    // On renvoi sur la page afficher pour voir le r�sultat, uniquement pour ce test, si tout s'est effectu�
    // normalement, le login et password ne s'afficheront pas, car ils n'�xistent plus
}

logout();
header("Location:" . INTRANET_ADRESS . "m/login/index.php");
?>
