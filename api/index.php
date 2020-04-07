<?php
require 'vendor/autoload.php';


//******************************
// Init
//-----------------
//
// init variables & app
//
//******************************

$settings = require 'settings.php';
$app = new \Slim\App($settings);



$app->get('/', function ($req, $res) {
  return $res->withJson(['message' => ''.$_SESSION["login_utilisateurformulaires"]]);
});


require 'dependencies.php';

//******************************
// RESTFUL API - M
//-----------------
//
// divided by files from the route folder.
//
//******************************


session_start();
if (!isset($_SESSION["login_utilisateurformulaires"]))
{
    header('Location: /m2/login/index.php');
    exit();
}
//Formulaires
include 'route/form.php';

//Chantiers
include 'route/chantiers.php';

//Admin
include 'route/admin.php';

//select
include 'route/select.php';

//Rapport
include 'route/rapports.php';

include 'route/qualifications.php';

include 'route/commandes.php';

include 'route/superadmin.php';


//******************************
// UTILS
//-----------------
//
// Utils & other functions used by RESFTUL APs
//
//******************************

function mailReport($mailSubject, $mailContent, $emailFrom, $emailTo){
  $sujet = $mailSubject;
  $message = "";
  $message .=" Lien direct pour le rapport :  $mailContent";

    $headers = "From: $emailFrom\n";
    $headers .= "Reply-To: $emailFrom\n";
    $headers .= "Content-Type: text/html; charset=\"utf-8\"";
    if (mail($emailTo, $sujet, $message, $headers)) {
        return 0;
    } else {
      mail($emailTo, $sujet, $message, $headers);
        return 1;
    }

}

function getMail($object,$name) {
  $sth = $object->dbm2->prepare("SELECT destEnCours, destHorsCours, mode FROM template WHERE nom like '$name'");
  try {
    $sth->execute();
    $result = $sth->fetchAll();
    if ($result[0]['mode'] == 0) {
      $result = $result[0]['destEnCours'];
    } else {
      $result = $result[0]['destHorsCours'];
    }
  } catch (\Exception $ex) {
    return $response->withJson(array('error' => $ex->getMessage()), 422);
  }
  return $result;
}

function getParameter($pdo, $key) {
  $sth = $pdo->prepare("SELECT `value` FROM `parameters` WHERE `key` LIKE :key");
  $sth->bindParam(':key', $key, PDO::PARAM_STR);

  try {
    $sth->execute();
    $result = $sth->fetch(PDO::FETCH_BOTH);
    return $result['value'];
  } catch (\Exception $ex) {
    return null;
  }
}

//TODO : Format e-mail sent
function mailSender($mailSubject, $mailContent, $emailFrom, $emailTo) {
  $sujet = $mailSubject;
  $message = "";
  $mailContent = json_decode($mailContent);
  foreach($mailContent as $key => $inputfield)
{
    $message .= "<p> $key : $inputfield </p> \n";
  }


  $headers = "From: $emailFrom\n";
  $headers .= "Reply-To: $emailFrom\n";
  $headers .= "Content-Type: text/html; charset=\"utf-8\"";
  if (mail($emailTo, $sujet, $message, $headers)) {
      return 0;
  } else {
    mail($emailTo, $sujet, $message, $headers);
      return 1;
  }
}

//TODO : Format e-mail sent
function mailSenderComplex($mailSubject, $mailContent, $emailFrom, $emailTo) {
  $sujet = $mailSubject;
  $message = "";
  $mailContent = json_decode($mailContent, TRUE);
  foreach($mailContent as $inputfield)
{
  $message .= "<p>". $inputfield['nom'] ." ". $inputfield['prenom'] ." - ". $inputfield['status'] ."  </p>";

    }


  $headers = "From: $emailFrom\n";
  $headers .= "Reply-To: $emailFrom\n";
  $headers .= "Content-Type: text/html; charset=\"utf-8\"";
  if (mail($emailTo, $sujet, $message, $headers)) {
      return 0;
  } else {
    mail($emailTo, $sujet, $message, $headers);
      return 1;
  }
}


// Utils

//caching on file system
function setContent($filename,$args) {
  $file = "log/".date("Ym")."-$filename.txt";
  $content = $args. "\n";
  return file_put_contents($file,$content, FILE_APPEND);
}

$app->run();
