<?php




  $app->get('/v1/mail/getMail/{mode}/{name}', function($request, $response, $args) {
    $name = $args['name'];
    $mode = $args['mode'];
    if ($mode == 0) {
        $sth = $this->dbm2->prepare("SELECT destEnCours FROM template WHERE nom like $name");
    }
    if ($mode == 1) {
        $sth = $this->dbm2->prepare("SELECT destHorsCours FROM template WHERE nom like $name");
    }


    try {
      $sth->execute();
      $result = $sth->fetchAll();
    } catch(\Exception $ex) {

      return $response->withJson(array('error' => $ex->getMessage()),422);

    }
      return $response->withJson($result, 200);
  });




  $app->post('/v1/mail/attributionMail', function($request, $response, $args){
    $data = $request->getParsedBody();
    $data = (json_encode($data));
    $data = json_decode($data, true);
    $mode = $data['mode'];
    setContent("Test", "Mode: ".$mode);
    foreach($data['templates'] as $entry) {
      $nomTemplate = $entry['nom'];
      $mailEnCours = $entry['destEnCours'];
      $mailHorsCours = $entry['destHorsCours'];
      $sth = $this->dbm2->prepare("UPDATE template SET destEnCours = '$mailEnCours', destHorsCours = '$mailHorsCours', mode = '$mode' WHERE nom = '$nomTemplate'");
      $sth->execute();
    }
  });



  $app->post('/v1/mail/submitMode', function($request, $response, $args){
    $data = $request->getParsedBody();
    $data = (json_encode($data));
    $data = json_decode($data, true);
    $mode = $data['mode'];
    foreach($data['templates'] as $template) {
      $nom = $tempmlate['nom'];
      $sth = $this->dbm2->prepare("UPDATE template SET mode = '$mailEnCours'");
      $sth->execute();
    }
  });


  $app->get('/v1/mail/gettemplates', function($request,$response){

    $sth = $this->dbm2->prepare("SELECT template_id, nom, destEnCours, destHorsCours, mode FROM template");

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
