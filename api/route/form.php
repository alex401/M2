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
   $data = json_decode($data, TRUE);
   $dataForMail = array('Nom du lieutenant: ' => $data['nomLieut'], 'Nom du soldat: ' => $data['nomSoldat']);

   foreach ($data['equipement'] as $key => $equipement) {
     $index = $key;
     // $result = setContent($typeCommande, $index);
     $dataForMail[$index] = $equipement['statut'];
     if (isset($equipement['nombre'])) {
      $dataForMail[$index] .= ' x '.$equipement['nombre'];
     }
     if (isset($equipement['taille'])) {
       $dataForMail[$index] .= ' Taille: '.$equipement['taille'];
     }
   }

   if (isset($data['remarque'])) {
      $dataForMail['Remarque: '] = $data['remarque'];
   }


   $dataForMail = (json_encode($dataForMail));

   try{
     //append to file named year-month
     $result = setContent($typeCommande, $dataForMail);
     $mail = mailSender($typeCommande, $dataForMail, "sud.commandement@pci-fr.ch", "sud.materiel@pci-fr.ch");
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


$app->post('/v1/form/radios', function ($request,$response) {

   $data = $request->getParsedBody();
   $data = (json_encode($data));
   $data = json_decode($data, TRUE);

   $dataForMail = array('Section' => $data['section'], 'Du' => $data['dateDe'], 'Au' => $data['dateA'], 'Pour' => '');
   foreach($data['hommes'] as $homme) {
     $name = $homme['grade'] .' '. $homme['name'];
     $dataForMail[$name] = 'Téléphone: '.$homme['tel'];
     if ($dataForMail!=''){
            $dataForMail[$name] .= ' Nombre de radios: '.$homme['nombre'];
     }
   }

   if(array_key_exists("commentaires", $data)) {
     $dataForMail['Commentaires'] = $data['commentaires'];
   }

   $dataForMail = (json_encode($dataForMail));

   try{
     //append to file named year-month
     $result = setContent("Radios", $dataForMail);
     $mail = mailSender("Radios", $dataForMail, "sud.commandement@pci-fr.ch", "sud.commandement@pci-fr.ch");

     //if someting was inserted
     if($result > 1 & $mail == 0){
       return $response->withJson(array('status' => 'OK'), 200);
     } else {
       return $response->withJson(array('error' => 'Erreur pendant commande de radios: echec envoie mail ou log.'), 422);
     }

   } catch(\Exception $ex){
     return $response->withJson(array('error' => 'Erreur pendant commande de radios: ' . $ex->getMessage()), 422);
   }

});
