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

  try {
    $this->dbm2->beginTransaction();

    $sth = $this->dbm2->prepare("INSERT INTO commandes (type, nom, chantier, statut, data) VALUES ('$type', '$nom', '$chantier', '$status', '$data')");
    $succes = $sth->execute();

    // Insert new history entry.
    $id = $this->dbm2->lastInsertId();
    $sth = $this->dbm2->prepare("INSERT INTO `commandes_hist`(`cmd_id`, `statut`) VALUES ($id, '$status')");
    $sth->execute();

    $this->dbm2->commit();

  } catch(\Exception $ex){

    $this->dbm2->roolback();

    return $response->withJson(array('error' => $ex->getMessage()), 422);
  }

  // Logging and mailing.
  // $data = (json_encode($data));
  // try {
  //   //append to file named year-month
  //   $result = setContent("repas", $data);
  //   $mail = mailSender("repas", $data, "sud.commandement@pci-fr.ch", "sud.commandement@pci-fr.ch");
  //
  //   //if someting was inserted
  //   if($result > 1 & $mail == 0) {
  //     return $response->withJson(array('status' => 'OK'),200);
  //   } else {
  //     return $response->withJson(array('status' => 'Erreur lors du logging ou mailing'),422);
  //   }
  //
  //   } catch(\Exception $ex){
  //     return $response->withJson(array('error' => $ex->getMessage()),422);
  //   }
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

$app->post('/v1/search/commandes', function ($request,$response) {
  $data = $request->getParsedBody();
  $data = (json_encode($data));
  $data = json_decode($data, true);

  $command = $data['command'];
  $rowid = $command['id'];
  $type = $command['type'];
  $nom = $command['client'];
  $date = $command['date'];

  $sth;

  // If rowid is specified, there should be only one result.
  if($rowid != "" && $date !="") {
    $sth = $this->dbm2->prepare("SELECT * FROM commandes WHERE rowid = $rowid AND type like '%$type%'
      AND nom like '%$nom%' AND DATE(timestampDate) >= '$date' AND DATE(timestampDate) < DATE_ADD('$date', INTERVAL 1 DAY)");
  } else if($rowid != "") {
    $sth = $this->dbm2->prepare("SELECT * FROM commandes WHERE rowid = $rowid AND type like '%$type%'
      AND nom like '%$nom%'");
  } else if($date !="") {
    $sth = $this->dbm2->prepare("SELECT * FROM commandes WHERE type like '%$type%'
      AND nom like '%$nom%' AND DATE(timestampDate) >= '$date' AND DATE(timestampDate) < DATE_ADD('$date', INTERVAL 1 DAY)");
  } else {
    $sth = $this->dbm2->prepare("SELECT * FROM commandes WHERE type like '%$type%' AND nom like '%$nom%'");
  }

  try {
    $sth->execute();
    $result = $sth->fetchAll();
  } catch(\Exception $ex) {
    return $response->withJson(array('error' => 'Failed to find command: ' . $ex->getMessage()), 422);
  }
  return $response->withJson($result, 200);


  // $sth = $this->dbm2->prepare("SELECT * FROM commandes WHERE type like '%$type%' AND nom like '%$nom%'
  //   AND DATE(timestampDate) >= '$date' AND DATE(timestampDate) < DATE_ADD('$date', INTERVAL 1 DAY)");
  // try {
  //   $sth->execute();
  //   $result = $sth->fetchAll();
  // } catch(\Exception $ex) {
  //   return $response->withJson(array('error' => 'Failed to find command: ' . $ex->getMessage()), 422);
  // }
  // return $response->withJson($result, 200);


});

$app->post('/v1/commande/update/{id}', function ($request,$response, $args) {

  $id = $args['id'];
  $data = $request->getParsedBody();

  $status = $data['statut'];


  try {
    $this->dbm2->beginTransaction();

    // Update command status.
    $sth = $this->dbm2->prepare("UPDATE commandes SET statut = '$status' WHERE rowid = $id;");
    $sth->execute();

    // Insert new history entry.
    $sth = $this->dbm2->prepare("INSERT INTO `commandes_hist`(`cmd_id`, `statut`) VALUES ($id, '$status')");
    $sth->execute();

    $this->dbm2->commit();

  } catch(\Exception $ex){

    $this->dbm2->rollback();

    return $response->withJson(array('error' => $ex->getMessage()), 422);
  }

  return $response->withJson(array('status' => 'OK'), 200);
});

// Get command history
$app->get('/v1/commande/hist/{id}', function ($request, $response, $args) {

  $id = $args['id'];

  $sth = $this->dbm2->prepare("SELECT * FROM commandes_hist WHERE `cmd_id` = $id ORDER BY `date` ASC");
  try {
    $sth->execute();
    $result = $sth->fetchAll();
  } catch(\Exception $ex) {
    return $response->withJson(array('error' => $ex->getMessage()), 422);
  }
  return $response->withJson($result, 200);
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
