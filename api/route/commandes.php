<?php

$app->post('/v1/commande/{type}', function ($request, $response, $args) {

  $type = $args['type'];

  if(!getTypeCommande($type)) {
    return $response->withJson(array('status' => 'Type de commande inconnue!'), 422);
  }

  $data = $request->getParsedBody();
  $mailData = $data;

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

    $sth = $this->dbm2->prepare(
      "INSERT INTO commandes (type, nom, chantier, statut, data) VALUES (:type, :nom, :chantier, :status, :data)"
    );
    $sth->bindParam(':type', $type, PDO::PARAM_STR);
    $sth->bindParam(':nom', $nom, PDO::PARAM_STR);
    $sth->bindParam(':chantier', $chantier, PDO::PARAM_STR);
    $sth->bindParam(':status', $status, PDO::PARAM_STR);
    $sth->bindParam(':data', $data, PDO::PARAM_STR);
    $succes = $sth->execute();

    // Insert new history entry.
    $id = $this->dbm2->lastInsertId();
    $sth = $this->dbm2->prepare("INSERT INTO `commandes_hist`(`cmd_id`, `statut`) VALUES ($id, :status)");
    $sth->bindParam(':status', $status, PDO::PARAM_STR);
    $sth->execute();

    $this->dbm2->commit();

  } catch(\Exception $ex){

    $this->dbm2->rollback();

    return $response->withJson(array('error' => $ex->getMessage()), 422);
  }

  // Check if the commands have to be auto validated and directly go to next status.
  $auto = getParameter($this->dbm2, 'auto_validate');
  // TODO c'est sale me semble
  if($auto == null) {
    return $response->withJson(array('error' => "Failed to get param auto_validate."), 422);
  }
  if($auto == '1') {
    // TODO find a way to not duplicate this code.
    try {
      $this->dbm2->beginTransaction();

      // Update command status.
      $autoStatus = 'attente de traitement';
      $sth = $this->dbm2->prepare("UPDATE commandes SET statut = '$autoStatus', remark = 'auto-validated' WHERE rowid = $id;");
      $sth->execute();

      // Insert new history entry.
      $sth = $this->dbm2->prepare("INSERT INTO `commandes_hist`(`cmd_id`, `statut`) VALUES ($id, '$autoStatus')");
      $sth->execute();

      $this->dbm2->commit();

    } catch(\Exception $ex) {
      $this->dbm2->rollback();
      return $response->withJson(array('error' => "Failed to update command during auto validation: " . $ex->getMessage()), 422);
    }
  }

  return $response->withJson(array('status' => 'OK', 'id' => $id), 200);

  // Logging and mailing.
  $mailData = (json_encode($mailData));
  try {
    //append to file named year-month
    $result = setContent($type, $mailData);
    $mail = mailSender($type, $mailData, "sud.commandement@pci-fr.ch", getMail($this,'Tickets'));

    //if someting was inserted
    if($result > 1 & $mail == 0) {
      return $response->withJson(array('status' => 'OK', 'id' => $id), 200);
    } else {
      return $response->withJson(array('status' => 'Erreur lors du logging ou mailing'),422);
    }

    } catch(\Exception $ex){
      return $response->withJson(array('error' => $ex->getMessage()),422);
    }
});

$app->get('/v1/select/commandes', function ($request,$response) {
  $sth = $this->dbm2->prepare("SELECT * FROM commandes ORDER BY timestampDate DESC");
  try {
    $sth->execute();
    $result = $sth->fetchAll();
  } catch(\Exception $ex) {
    return $response->withJson(array('error' => $ex->getMessage()), 422);
  }
  return $response->withJson($result, 200);
});

$app->post('/v1/search/commandes', function ($request, $response) {
  $data = $request->getParsedBody();
  $data = (json_encode($data));
  $data = json_decode($data, true);

  $command = $data['command'];
  $rowid = $command['id'];
  $type = $command['type'];
  $type = "%".$type."%";
  $nom = $command['client'];
  $nom = "%".$nom."%";
  $dateEnvoi = $command['date'];
  $chantier = $command['chantier'];
  if($chantier == "") {
    $chantier = "%%";
  }

  // If rowid is specified, there should be only one result. TODO change logic like for chantier.
  if($rowid != "" && $dateEnvoi !="") {
    $sth = $this->dbm2->prepare(
      "SELECT * FROM commandes
      WHERE rowid = :rowid AND type LIKE :type AND chantier LIKE :chantier AND nom LIKE :nom
        AND DATE(timestampDate) >= :dateEnvoi AND DATE(timestampDate) < DATE_ADD(:dateEnvoi, INTERVAL 1 DAY)
      ORDER BY timestampDate DESC"
    );
    $sth->bindParam(':rowid', $rowid, PDO::PARAM_INT);
    $sth->bindParam(':type', $type, PDO::PARAM_STR);
    $sth->bindParam(':nom', $nom, PDO::PARAM_STR);
    $sth->bindParam(':dateEnvoi', $dateEnvoi, PDO::PARAM_STR);
    $sth->bindParam(':chantier', $chantier, PDO::PARAM_STR);

  } else if($rowid != "") {
    $sth = $this->dbm2->prepare(
      "SELECT *
      FROM commandes
      WHERE rowid = :rowid AND type LIKE :type AND chantier LIKE :chantier AND nom LIKE :nom
      ORDER BY timestampDate DESC"
    );
    $sth->bindParam(':rowid', $rowid, PDO::PARAM_INT);
    $sth->bindParam(':type', $type, PDO::PARAM_STR);
    $sth->bindParam(':nom', $nom, PDO::PARAM_STR);
    $sth->bindParam(':chantier', $chantier, PDO::PARAM_STR);

  } else if($dateEnvoi !="") {
    $sth = $this->dbm2->prepare(
      "SELECT * FROM commandes WHERE type LIKE :type AND chantier LIKE :chantier AND nom LIKE :nom
        AND DATE(timestampDate) >= :dateEnvoi AND DATE(timestampDate) < DATE_ADD(:dateEnvoi, INTERVAL 1 DAY)
      ORDER BY timestampDate DESC"
      );
    $sth->bindParam(':type', $type, PDO::PARAM_STR);
    $sth->bindParam(':nom', $nom, PDO::PARAM_STR);
    $sth->bindParam(':dateEnvoi', $dateEnvoi, PDO::PARAM_STR);
    $sth->bindParam(':chantier', $chantier, PDO::PARAM_STR);

  } else {
    $sth = $this->dbm2->prepare(
      "SELECT * FROM commandes WHERE type LIKE :type AND nom LIKE :nom AND chantier LIKE :chantier
      ORDER BY timestampDate DESC"
    );
    $sth->bindParam(':type', $type, PDO::PARAM_STR);
    $sth->bindParam(':nom', $nom, PDO::PARAM_STR);
    $sth->bindParam(':chantier', $chantier, PDO::PARAM_STR);
  }

  try {
    $sth->execute();
    $result = $sth->fetchAll();
  } catch(\Exception $ex) {
    return $response->withJson(array('error' => 'Failed to find command: ' . $ex->getMessage()), 422);
  }

  return $response->withJson($result, 200);
});

// Update status and optional remark of a command.
$app->post('/v1/commande/update/{id}', function ($request, $response, $args) {

  $id = $args['id'];
  $data = $request->getParsedBody();

  $status = $data['statut'];
  $remark = $data['remark'];

  try {
    $this->dbm2->beginTransaction();

    // Update command status.
    $sth = $this->dbm2->prepare("UPDATE commandes SET statut = '$status', remark = :remark WHERE rowid = $id;");
    $sth->bindParam(':remark', $remark, PDO::PARAM_STR);
    $sth->execute();

    // Insert new history entry.
    $sth = $this->dbm2->prepare("INSERT INTO `commandes_hist`(`cmd_id`, `statut`) VALUES ($id, '$status')");
    $sth->execute();

    $this->dbm2->commit();

  } catch(\Exception $ex){
    $this->dbm2->rollback();
    return $response->withJson(array('error' => "Failed to update command: " . $ex->getMessage()), 422);
  }

  return $response->withJson(array('status' => 'OK'), 200);
});

// Get command history.
$app->get('/v1/commande/hist/{id}', function ($request, $response, $args) {

  $id = $args['id'];

  $sth = $this->dbm2->prepare(
    "SELECT cmd_id, statut, max(date) as date
    FROM `commandes_hist`
    WHERE cmd_id = $id GROUP BY cmd_id, statut ORDER BY date ASC, rowid ASC"
  );

  try {
    $sth->execute();
    $result = $sth->fetchAll();
  } catch(\Exception $ex) {
    return $response->withJson(array('error' => "Failed to get command history: " . $ex->getMessage()), 422);
  }
  return $response->withJson($result, 200);
});

// Get command by id.
$app->get('/v1/commandes/{id}', function ($request, $response, $args) {

  $id = $args['id'];

  $sth = $this->dbm2->prepare("SELECT * FROM `commandes` WHERE `rowid` = $id");

  try {
    $sth->execute();
    $result = $sth->fetch();
  } catch(\Exception $ex) {
    return $response->withJson(array('error' => 'Failed to get command: ' . $id . '. ' . $ex->getMessage()), 422);
  }

  return $response->withJson($result, 200);
});


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
