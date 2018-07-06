<?php

require("../../config/config.php");
include("../login/isEnSession.php");
$back="<a href =../index.php>retour</a>";
$logout="<a href =../login/logout.php rel=external>logout</a>";
include("../header.php");

$formation = trim(utf8_decode(addslashes(htmlspecialchars(isset($_POST['formation']) ? $_POST['formation'] : ''))));
$session = trim(utf8_decode(addslashes(htmlspecialchars(isset($_POST['session']) ? $_POST['session'] : ''))));
$commentaires = trim(utf8_decode(addslashes(htmlspecialchars(isset($_POST['commentaires']) ? $_POST['commentaires'] : ''))));
$Stagiairerowid = (isset($_POST['stagiaire']) ? $_POST['stagiaire'] : '');

$DatabaseAccessProvider = connectToDolibarrDB();
$mailContent = "";
$mailSubject = "";

if ($Stagiairerowid != "") {
	// Display cours information
	$sql = "SELECT DATE_FORMAT(session.dated, '%Y.%m.%d'), DATE_FORMAT(session.datef, '%Y.%m.%d'), formationcatalogue.intitule " .
		"FROM llx_agefodd_formation_catalogue as formationcatalogue, llx_agefodd_session as session " .
		"WHERE " .
		"session.rowid = " . $session . " AND " .
		"session.fk_formation_catalogue = formationcatalogue.rowid ";

	$recFormations = mysqli_fetch_array(mysqli_query($DatabaseAccessProvider, $sql));

	$sessiondatedebut = $recFormations[0];
	$sessiondatefin = $recFormations[1];
	$formation = $recFormations[2];
	$mailSubject = "Qualification pour le cours $formation ($sessiondatedebut - $sessiondatefin)";
	$mailContent .= "<p><h1>Cours: $formation ($sessiondatedebut - $sessiondatefin)</h1></p>";

	// Display stagiaire
	$sql = "SELECT * FROM llx_agefodd_stagiaire as stagiaire WHERE stagiaire.rowid=".$Stagiairerowid;

	$rec = mysqli_fetch_array(mysqli_query($DatabaseAccessProvider, $sql));

	$nom = htmlspecialchars(ucwords(strtolower($rec['nom'])));
	$prenom = htmlspecialchars($rec['prenom']);
	$civilite = htmlspecialchars($rec['civilite']);
	$tel2 = htmlspecialchars($rec['tel2']);

	$mailContent .= "<p><h1>" . $nom . " " . $prenom . "( " . $civilite . ") - " . $tel2  . "</h1></p>";
    $mailContent .= "</br>";

	// et ensuite les questions
	$mailContent .= "<table><tr><th>Question</th><th>Réponse</th></tr>";
	$mailContent .= "	<tr><th colspan=2>Connaissances de base :</th></tr>";
	$mailContent .= "	<tr><td>"."Comportement, attitude"."</td><td>".getnote($_POST['Comportement'])."</td></tr>\n";
	$mailContent .= "	<tr><td>"."Motivation, engagement, entreprenant"."</td><td>".getnote($_POST['Motivation'])."</td></tr>";
	$mailContent .= "	<tr><td>"."Connaissances techniques"."</td><td>".getnote($_POST['Connaissances'])."</td></tr>\n";
	$mailContent .= "	<tr><td>"."Facult&eacute; d'expression"."</td><td>".getnote($_POST['Faculte'])."</td></tr>";
	$mailContent .= "	<tr><td>"."Aptitude &agrave; la fonction"."</td><td>".getnote($_POST['Aptitude'])."</td></tr>\n";
	$mailContent .= "	<tr><td>"."Appr&eacute;ciation globale"."</td><td>".getnote($_POST['Appreciation'])."</td></tr>";
	$mailContent .= "	<tr><td colspan=2><hr></td></tr>";
	$mailContent .= "	<tr><th colspan=2>Cadres et spécialistes :</th></tr>\n";
	$mailContent .= "	<tr><td>"."Capacit&eacute; d'appr&eacute;ciation de la situation"."</td><td>".getnote($_POST['Situation'])."</td></tr>\n";
	$mailContent .= "	<tr><td>"."Capacit&eacute; de d&eacute;cision"."</td><td>".getnote($_POST['decision'])."</td></tr>";
	$mailContent .= "	<tr><td>"."Capacit&eacute; d'instruire"."</td><td>".getnote($_POST['instruire'])."</td></tr>\n";
	$mailContent .= "	<tr><td>"."Aptitude &agrave; conduire"."</td><td>".getnote($_POST['conduire'])."</td></tr>";
	$mailContent .= "	<tr><td>"."Aptitude &agrave; la fonction"."</td><td>".getnote($_POST['fonction'])."</td></tr>\n";
	$mailContent .= "	<tr><td>"."Appr&eacute;ciation globale"."</td><td>".getnote($_POST['AppreciationCadre'])."</td></tr>";
	$mailContent .= "	<tr><td colspan=2><hr></td></tr>";
	$mailContent .= "	<tr><td>"."Proposition d’avancement <br>ou d’instruction complémentaire"."</td><td>".$_POST['Proposition']."</td></tr>\n";
	$mailContent .= "	<tr><td>"."Etablit par "."</td><td>".$_SESSION["nom_utilisateurformulaires"]." ".$_SESSION["prenom_utilisateurformulaires"].", le ".date("d.m.Y") ."</td></tr>";

	$mailContent .= "</table>";
	if ($commentaires != "")
	{
	    $mailContent .= "<p>Commentaires: " . $commentaires . "</p>";
	}

    mysqli_close($DatabaseAccessProvider);

	// Send email
	$emailFrom = "info.sud@pci-fr.ch";
        $emailTo = "sud.commandement@pci-fr.ch";
	//$emailTo = "sud.rh@pci-fr.ch";
	$sujet = $mailSubject;
	$message = $mailContent;
	$headers = "From: $emailFrom\n";
	$headers .= "Reply-To: $emailFrom\n";
	$headers .= "Content-Type: text/html; charset=\"utf-8\"";

	if (mail($emailTo, $sujet, $message, $headers))
		echo "L'email a bien été envoyé.";
	else
		echo "Une erreur c'est produite lors de l'envois de l'email.";

} else
	echo "L'email n'a pas été envoyé car aucun stagiaire n'a été choisi.";

include("../footer.php");

function getnote($num)
{
	switch ($num) {
		case 0 : return 'Insuffisant';
		case 1 : return 'Suffisant';
		case 2 : return 'Bon';
		case 3 : return 'Tres bon';
	}
}
?>
