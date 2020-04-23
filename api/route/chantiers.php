<?php

// Get list of chantiers.
$app->get('/v1/chantiers', function ($request, $response) {

  $sth = $this->dbdoll->prepare("SELECT `rowid`, `title`, `date_close` FROM `llx_projet` WHERE fk_statut = 1 ORDER BY title;");

  try {
    $sth->execute();
    $result = $sth->fetchAll();

    if($result) {
      return $response->withJson($result, 200);
    } else {
      return $response->withJson(array('status' => "No chantier found."), 200);
    }
  } catch(\Exception $ex) {
    return $response->withJson(array('error' => "Failed to get chantiers list: " . $ex->getMessage()), 422);
  }
});
