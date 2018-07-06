<?php


//******************************
// repas
//-----------------
//
//
//
//******************************

$app->post('/v1/form/repas', function ($request,$response) {

   $data = $request->getParsedBody();
   $data = (json_encode($data));
   try{
     //append to file named year-month
     $result = setContent("repas",$data);
     $mail = mailSender("repas", $data, "sud.commandement@pci-fr.ch", "sud.commandement@pci-fr.ch");

     //if someting was inserted
     if($result > 1 & $mail == 0){
       return $response->withJson(array('status' => 'OK'),200);
     }
     else {
     return $response->withJson(array('status' => 'Erreur pendant commande de repas'),422);
     }
   }
   catch(\Exception $ex){
     return $response->withJson(array('error' => $ex->getMessage()),422);
   }
});

//******************************
// carburant
//-----------------
//
//
//
//******************************

$app->post('/v1/form/carburant', function ($request,$response) {

  $typeCommande = "carburant";

   $data = $request->getParsedBody();
   $data = (json_encode($data));
   try{
     //append to file named year-month
     $result = setContent($typeCommande, $data);
     $mail = mailSender($typeCommande, $data, "sud.commandement@pci-fr.ch", "sud.commandement@pci-fr.ch");
     //if someting was inserted
     if($result > 1 & $mail == 0){
       return $response->withJson(array('status' => 'OK'),200);
     }
     else {
     return $response->withJson(array('status' => 'Erreur pendant commande de'+ $typeCommande),422);
     }
   }
   catch(\Exception $ex){
     return $response->withJson(array('error' => $ex->getMessage()),422);
   }
});



//******************************
// carburant
//-----------------
//
//
//
//******************************

$app->post('/v1/form/transport', function ($request,$response) {

  $typeCommande = "transport";

   $data = $request->getParsedBody();
   $data = (json_encode($data));
   try{
     //append to file named year-month
     $result = setContent($typeCommande, $data);
     $mail = mailSender($typeCommande, $data, "sud.commandement@pci-fr.ch", "sud.commandement@pci-fr.ch");
     //if someting was inserted
     if($result > 1 & $mail == 0){
       return $response->withJson(array('status' => 'OK'),200);
     }
     else {
     return $response->withJson(array('status' => 'Erreur pendant commande de'+ $typeCommande),422);
     }
   }
   catch(\Exception $ex){
     return $response->withJson(array('error' => $ex->getMessage()),422);
   }
});
//******************************
// Materiel
//-----------------
//
//
//
//******************************

$app->post('/v1/form/materiel', function ($request,$response) {

  $typeCommande = "materiel";

   $data = $request->getParsedBody();
   $data = (json_encode($data));

   try{
     //append to file named year-month
     $result = setContent($typeCommande, $data);
     $mail = mailSender($typeCommande, $data, "sud.commandement@pci-fr.ch", "sud.commandement@pci-fr.ch");

     //if someting was inserted
     if($result > 1 & $mail == 0){
       return $response->withJson(array('status' => 'OK'),200);
     }
     else {
     return $response->withJson(array('status' => 'Erreur pendant commande de'+ $typeCommande),422);
     }
   }
   catch(\Exception $ex){
     return $response->withJson(array('error' => $ex->getMessage()),422);
   }
});


//******************************
// demande congé
//-----------------
//
//
//
//******************************

$app->post('/v1/form/demandeconge', function ($request,$response) {

  $typeCommande = "demandeconge";

   $data = $request->getParsedBody();
   $data = (json_encode($data));
   try{
     //append to file named year-month
     $result = setContent($typeCommande, $data);
     $mail = mailSender($typeCommande, $data, "sud.commandement@pci-fr.ch", "sud.commandement@pci-fr.ch");
     //if someting was inserted
     if($result > 1 & $mail == 0){
       return $response->withJson(array('status' => 'OK'),200);
     }
     else {
     return $response->withJson(array('status' => 'Erreur pendant commande de'+ $typeCommande),422);
     }
   }
   catch(\Exception $ex){
     return $response->withJson(array('error' => $ex->getMessage()),422);
   }
});


//******************************
// Etat circulation
//-----------------
//
//
//
//******************************

$app->post('/v1/form/etatcirculation', function ($request,$response) {

  $typeCommande = "etatcirculation";

   $data = $request->getParsedBody();
   $data = (json_encode($data));
   try{
     //append to file named year-month
     $result = setContent($typeCommande, $data);
     $mail = mailSender($typeCommande, $data, "sud.commandement@pci-fr.ch", "sud.commandement@pci-fr.ch");
     //if someting was inserted
     if($result > 1 & $mail == 0){
       return $response->withJson(array('status' => 'OK'),200);
     }
     else {
     return $response->withJson(array('status' => 'Erreur pendant commande de'+ $typeCommande),422);
     }
   }
   catch(\Exception $ex){
     return $response->withJson(array('error' => $ex->getMessage()),422);
   }
});


//******************************
// Ctrl équipement
//-----------------
//
//
//
//******************************

$app->post('/v1/form/ctrlequipement', function ($request,$response) {

  $typeCommande = "ctrlequipement";

   $data = $request->getParsedBody();
   $data = (json_encode($data));
   try{
     //append to file named year-month
     $result = setContent($typeCommande, $data);
     $mail = mailSender($typeCommande, $data, "sud.commandement@pci-fr.ch", "sud.commandement@pci-fr.ch");
     //if someting was inserted
     if($result > 1 & $mail == 0){
       return $response->withJson(array('status' => 'OK'),200);
     }
     else {
     return $response->withJson(array('status' => 'Erreur pendant commande de'+ $typeCommande),422);
     }
   }
   catch(\Exception $ex){
     return $response->withJson(array('error' => $ex->getMessage()),422);
   }
});


//******************************
// Suivi machine
//-----------------
//
//
//
//******************************

$app->post('/v1/form/suivimachine', function ($request,$response) {

  $typeCommande = "suivimachine";

   $data = $request->getParsedBody();
   $data = (json_encode($data));

   try{
     //append to file named year-month
     $result = setContent($typeCommande, $data);
     $mail = mailSender($typeCommande, $data, "sud.commandement@pci-fr.ch", "sud.commandement@pci-fr.ch");
     //if someting was inserted
     if($result > 1 & $mail == 0){
       return $response->withJson(array('status' => 'OK'),200);
     }
     else {
       return $response->withJson(array('status' => 'Erreur pendant commande de'+ $typeCommande),422);
     }
   }
   catch(\Exception $ex){
     return $response->withJson(array('error' => $ex->getMessage()),422);
   }
});

//******************************
// Suivi chantier
//-----------------
//
//
//
//******************************

$app->post('/v1/form/suivichantier', function ($request,$response) {

  $typeCommande = "suivichantier";

   $data = $request->getParsedBody();
   $data = (json_encode($data));
   try{
     //append to file named year-month
     $result = setContent($typeCommande, $data);
     $mail = mailSender($typeCommande, $data, "sud.commandement@pci-fr.ch", "sud.commandement@pci-fr.ch");
     //if someting was inserted
     if($result > 1 & $mail == 0){
       return $response->withJson(array('status' => 'OK'),200);
     }
     else {
     return $response->withJson(array('status' => 'Erreur pendant commande de'+ $typeCommande),422);
     }
   }
   catch(\Exception $ex){
     return $response->withJson(array('error' => $ex->getMessage()),422);
   }
});

//******************************
// Première entree
//-----------------
//
//
//
//******************************

$app->post('/v1/form/premierentree', function ($request,$response) {

  $typeCommande = "premiereentree";

   $data = $request->getParsedBody();
   $data = (json_encode($data));
   try{
     //append to file named year-month
     $result = setContent($typeCommande, $data);
     $mail = mailSender($typeCommande, $data, "sud.commandement@pci-fr.ch", "sud.commandement@pci-fr.ch");
     //if someting was inserted
     if($result > 1 & $mail == 0){
       return $response->withJson(array('status' => 'OK'),200);
     }
     else {
     return $response->withJson(array('status' => 'Erreur pendant commande de'+ $typeCommande),422);
     }
   }
   catch(\Exception $ex){
     return $response->withJson(array('error' => $ex->getMessage()),422);
   }
});


//******************************
// Demande avancement
//-----------------
//
//
//
//******************************

$app->post('/v1/form/demandeavance', function ($request,$response) {

  $typeCommande = "demandeavance";

   $data = $request->getParsedBody();
   $data = (json_encode($data));
   try{
     //append to file named year-month
     $result = setContent($typeCommande, $data);
     $mail = mailSender($typeCommande, $data, "sud.commandement@pci-fr.ch", "sud.commandement@pci-fr.ch");
     //if someting was inserted
     if($result > 1 & $mail == 0){
       return $response->withJson(array('status' => 'OK'),200);
     }
     else {
     return $response->withJson(array('status' => 'Erreur pendant commande de'+ $typeCommande),422);
     }
   }
   catch(\Exception $ex){
     return $response->withJson(array('error' => $ex->getMessage()),422);
   }
});

//******************************
// Rapport Parking
//-----------------
//
//
//
//******************************

$app->post('/v1/form/rapportparking', function ($request,$response) {

  $typeCommande = "rapportparking";
   $data = $request->getParsedBody();
   $data = (json_encode($data));

   try{
     //append to file named year-month
     $result = setContent($typeCommande, $data);
     $mail = mailSender($typeCommande, $data, "sud.commandement@pci-fr.ch", "sud.commandement@pci-fr.ch");
     //if someting was inserted
     if($result > 1 & $mail == 0){
       return $data;
       return $response->withJson(array('status' => 'OK'),200);
     }
     else {
     return $response->withJson(array('status' => 'Erreur pendant commande de'+ $typeCommande),422);
     }
   }
   catch(\Exception $ex){
     return $response->withJson(array('error' => $ex->getMessage()),422);
   }
});
