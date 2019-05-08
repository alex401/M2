<?php



  $app->post('/v1/mail/attributionMail', function($request, $response, $args){
    $data = $request->getParsedBody();
    $data = (json_encode($data));
    $data = json_decode($data, true);
    foreach($data as $entry) {
      $nomTemplate = $entry['nom'];
      $mailEnCours = $entry['destEnCours'];
      $mailHorsCours = $entry['destHorsCours'];
      $sth = $this->dbm2->prepare("UPDATE template SET destEnCours = '$mailEnCours', destHorsCours = '$mailHorsCours' WHERE nom = '$nomTemplate'");
      $sth->execute();
    }
  });



  $app->get('/v1/mail/gettemplates', function($request,$response){

    $sth = $this->dbm2->prepare("SELECT template_id, nom, destEnCours, destHorsCours FROM template");

        try{
          $sth->execute();
          $result = $sth->fetchAll();

        if($result){
            return $response->withJson($result,200);
          }
          else {
          return $response->withJson(array('status' => 'Erreur'),422);
          }
        }
        catch(\Exception $ex){
          return $response->withJson(array('error' => $ex->getMessage()),422);
        }
    });
