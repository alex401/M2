<?php

$app->post('/v1/commande/{type}', function ($request,$response, $args) {

  $type = $args['type'];

  if(!getTypeCommande($type)) {
    return $response->withJson(array('status' => 'Type de commande inconnue!'), 422);
  }

  $data = $request->getParsedBody();

  // Inserting command in DB.
  $type = $data['type'];
  $nom = $data['nom'];
  $chantier = $data['chantier'];
  $status = "attente de validation";

  // Remove already taken fields.
  array_splice($data, 0, 3);
  $data = json_encode($data);

  $sth = $this->dbm2->prepare("INSERT INTO commandes (type, nom, chantier, statut, data) VALUES ('$type', '$nom', '$chantier', '$status', '$data')");

  try {
    $succes = $sth->execute();

  } catch(\Exception $ex){
    return $response->withJson(array('error' => $ex->getMessage()), 422);
  }

  // Logging and mailing.
  $data = (json_encode($data));
  try {
    //append to file named year-month
    $result = setContent("repas", $data);
    $mail = mailSender("repas", $data, "sud.commandement@pci-fr.ch", "sud.commandement@pci-fr.ch");

    //if someting was inserted
    if($result > 1 & $mail == 0) {
      return $response->withJson(array('status' => 'OK'),200);
    } else {
      return $response->withJson(array('status' => 'Erreur lors du logging ou mailing'),422);
    }

    } catch(\Exception $ex){
      return $response->withJson(array('error' => $ex->getMessage()),422);
    }
});

$app->get('/v1/select/commandes', function ($request,$response) {
  $sth = $this->dbm2->prepare("SELECT * FROM commandes");
  try {
    $sth->execute();
    $result = $sth->fetchAll();
  } catch(\Exception $ex) {
    return $response->withJson(array('error' => $ex->getMessage()), 422);
  }
  return $response->withJson($result, 200);
});

$app->post('/v1/commande/update/{id}', function ($request,$response, $args) {

  $id = $args['id'];
  $data = $request->getParsedBody();

  $status = $data['statut'];

  //$data = json_encode($data);

  $sth = $this->dbm2->prepare("UPDATE commandes SET statut = '$status' WHERE rowid = $id;");

  try {
    $succes = $sth->execute();

  } catch(\Exception $ex){
    return $response->withJson(array('error' => $ex->getMessage()), 422);
  }
});

// Insert a new command in the database. TODO move this in the route above.
/*$app->post('/v1/commandes/insertcommand', function ($request, $response) {

  $data = $request->getParsedBody();

  $type = $data['type'];
  $nom = $data['nom'];
  $chantier = $data['chantier'];
  $status = "attente de validation";

  // Remove already taken fields.
  array_splice($data, 0, 3);
  $data = json_encode($data);

  $sth = $this->dbm2->prepare("INSERT INTO commandes (type, nom, chantier, statut, data) VALUES ('$type', '$nom', '$chantier', '$status', '$data')");

  try {
    $succes = $sth->execute();

  } catch(\Exception $ex){
    return $response->withJson(array('error' => $ex->getMessage()), 422);
  }

  return $response->withJson(array('status' => 'OK'), 200);
});

$app->get('/v1/select/commandes', function ($request,$response) {

  $sth = $this->dbm2->prepare("SELECT * FROM commandes");

  try {
    $sth->execute();
    $result = $sth->fetchAll();
  } catch(\Exception $ex) {
    return $response->withJson(array('error' => $ex->getMessage()), 422);
  }

  return $response->withJson($result, 200);
});*/

// UTILS
function getTypeCommande($type) {
  switch ($type) {
    case 'repas' : return true;
    case 'materiel' : return true;
    case 'carburant' : return true;
    case 'transport' : return true;
    default : return false;
  }
}
