<?php

//require("../login/config/config.php");

$mailContent = "";
$mailSubject = "";
$datejour =  date('m/d/Y - H:i', time());

//HEADER
$mailSubject = "Rapport de $_POST[sectionRapport] - $_POST[formation] - $datejour  ";
$mailContent .= "<img alt='' src='http://www.pci-fr.ch/erppci/viewimage.php?cache=1&amp;modulepart=companylogo&amp;file=thumbs%2Fpci_logo_small.png' id='img_logo' align='right'><p><h1> Opération :  $_POST[formation] </h1></p>";
$mailContent .= "<h2> Rapport journalier </h2></p>";
$mailContent .= "<p><h2> Date - heure : $datejour  </h1></p>";
$mailContent .= "<h3> Section - $_POST[sectionRapport] </h3></p>";
$mailContent .= "<h1> Etat de la situation</h1></p>";
$mailContent .= "<h3> Situation actuelle :</h3> </p> $_POST[situationActuelle] </p>";

//MOYENS ENGAGES

$mailContent .= "<h1> Moyens engagés </h1>";
$mailContent .= "<h2> Hommes </h2> <p> ";
$mailContent .= "<table border='1' >
                  <tr>
                    <th> Grade </th>
                    <th> Responsable Nom </th>
                    <th> Prenom </th>
                    <th> + nombre d'hommes </th>
                  </tr>";
                  if($_POST[homme] != null){
                  foreach ($_POST[homme] as $key => $value) {
                    $mailContent .= "
                    <tr>
                      <td> $value[grade] </td>
                      <td> $value[nom] </td>
                      <td> $value[prenom] </td>
                      <td> $value[nbrH] </td>
                    </tr>";
                  }
                  }

$mailContent .= " </table>";
$mailContent .= "<h2> Véhicule </h2>
<p> <table border='1'>
<tr>
  <th> Nombre </th>
  <th> Description </th>
</tr>";

if($_POST[vehicules] != null){
foreach ($_POST[vehicules] as $key => $value) {
  $mailContent .= "<tr>
  <td> $value[nbr]  </td>
  <td> $value[desc] </td>
  </tr>";
}
}
$mailContent .= " </table>";
$mailContent .= "<h2> Materiel </h2>

<p> <table border='1'>
<tr>
  <th> Nombre </th>
  <th> Description </th>
</tr>";
if($_POST[materiel] != null){
foreach ($_POST[materiel] as $key => $value) {
  $mailContent .= "<tr>
  <td> $value[nbr] </td>
  <td>  $value[desc]</td>
  </tr>";
}
}
$mailContent .= " </table>";

//MISSION

$mailContent .= "<h2> Missions </h2>
<p> <table border='1'>
<tr>
  <th> Responsable </th>
  <th> Lieu </th>
  <th> Description </th>
</tr>";

if($_POST[mission] != null){
foreach ($_POST[mission] as $key => $value) {
  $mailContent .= "<tr>
  <td>  $value[resp] </td>
  <td>  $value[lieu] </td>
  <td>  $value[desc] </td>
  </tr>";
}
}
$mailContent .= " </table>";
$mailContent .= "<h2> Missions transmises </h2>
<p> <table border='1'>
<tr>
  <th> Mission </th>
</tr>";
if ($_POST[missionTrans]){
foreach ($_POST[missionTrans] as $key => $value) {
  $mailContent .= "<tr>
  <td>  $value[desc] </td>
  </tr>";
}
}
$mailContent .= " </table>";
// PLANNING
$mailContent .= "<h2> Planning </h2>
<p> <table border='1'>
<tr>
  <th> Heure </th>
  <th> tache </th>
</tr>";
if ($_POST[planning] != null){
foreach ($_POST[planning] as $key => $value) {
  $mailContent .= "<tr>
  <td>  $value[heure] </td>
  <td>  $value[tache] </td>
  </tr>";
}
}
$mailContent .= " </table>";
$mailContent .= "<h2>Commentaire</h2> </p> $_POST[commentaire]";

//METEO
$mailContent .= "<h1> Meteo </h1> </p>";
$mailContent .= " </p> ";
$mailContent .= "Selection : $_POST[rangeInput] - $_POST[rangeHiddenText]";

echo "$mailContent </p>";

// Send email
$emailFrom = "info.sud@pci-fr.ch";

$emailTo = "info.sud@pci-fr.ch";
$emailCc = "alex401@gmail.com, info.sud@pci-fr.ch";

$sujet = $mailSubject;
$message = $mailContent;
$headers = "From: $emailFrom\n";
$headers .= "Reply-To: $emailFrom\n";
$headers .= "Cc: $emailCc\n";
$headers .= "Content-Type: text/html; charset=\"utf-8\"";

if (mail($emailTo, $sujet, $message, $headers))
  echo "L'email a bien été envoyé.";
else
  echo "Une erreur c'est produite lors de l'envois de l'email.";


?>
