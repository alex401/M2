<?php

require("config.php");
//require("../config/config.php");
// On déclare la variable d'URL pour prendre sa valeur
$login = addslashes(htmlspecialchars(isset($_POST['login']) ? $_POST['login'] : ''));
$motdepasse = addslashes(htmlspecialchars(isset($_POST['motdepasse']) ? $_POST['motdepasse'] : ''));

function check_login($dbProvider, $_login, $_motdepasse) {
    // On reprend la valeur des variables depuis le formulaire
    $sql = mysqli_query($dbProvider, "SELECT * FROM utilisateursformulaires WHERE login='$_login'");
    $infos = mysqli_fetch_array($sql);
    mysqli_close($dbProvider);
    $motdepasse_utilisateur = $infos['motdepasse'];
    $email = $infos['email'];
    $nom = $infos['nom'];
    $prenom = $infos['prenom'];
    $usertype = $infos['usertype'];
    $md5motdepasse = md5($_motdepasse);

    if ($md5motdepasse == $motdepasse_utilisateur) {
        session_start(); // on démarre une session
        $_SESSION["login_utilisateurformulaires"] = $_login;
        $_SESSION["email_utilisateurformulaires"] = $email;
        $_SESSION["nom_utilisateurformulaires"] = $nom;
        $_SESSION["prenom_utilisateurformulaires"] = $prenom;
        $_SESSION["usertype_utilisateurformulaires"] = $usertype;

        return(true);
    } else {
        return(false);
    }
}

if (check_login(connectToDB(), $login, $motdepasse)) {

    if ($_SESSION["usertype_utilisateurformulaires"] == "info"){
        header("Location: ../#/form/entreeservice");
    } else {
        header("Location: ../#/");
    }


} else {
    header("Location: index.php?erreur=1");
}
?>
</html>
