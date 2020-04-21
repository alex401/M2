<?php

// Return list of all categories.
$app->get('/v1/select/categories', function ($request, $response) {

  $sth = $this->dbdoll->prepare("SELECT rowId, label FROM llx_categorie WHERE type=2 ORDER BY label");

  try{
    $sth->execute();
    $result = $sth->fetchAll();

    if($result) {
      return $response->withJson($result, 200);
    } else {
      return $response->withJson(array('status' => "No categories found."), 200);
    }
  } catch(\Exception $ex){
    return $response->withJson(array('error' => "Failed to get categories list: " . $ex->getMessage()), 422);
  }
});

// Return list of all tags.
$app->get('/v1/select/entreeservice/tags', function ($request, $response) {

  $sth = $this->dbdoll->prepare(
    "SELECT rowid, label, color, 'false' as checked
    FROM `llx_categorie`
    WHERE type = 4 AND (color = 'ff56ff' OR color = 'aaffaa' OR color = '5f00bf' OR color = '007f00' OR color = '003f7f' OR color = '00bfbf' OR NULL)
    ORDER BY label"
  );
  try {
    $sth->execute();
    $result = $sth->fetchAll();
    if($result) {
      return $response->withJson($result, 200);
    } else {
      return $response->withJson(array('status' => 'Erreur'), 422);
    }
  } catch(\Exception $ex){
    return $response->withJson(array('error' => $ex->getMessage()), 422);
  }
});

// Return list of formations.
$app->get('/v1/select/formations', function ($request,$response) {

  $sth = $this->dbdoll->prepare(
    "SELECT rowId, intitule
    FROM llx_agefodd_formation_catalogue
    WHERE archive=0 AND intitule != ''
    ORDER BY intitule"
  );

  try {
    $sth->execute();
    $result = $sth->fetchAll();

    if($result) {
      return $response->withJson($result, 200);
    } else {
      return $response->withJson(array('status' => 'Erreur'), 422);
    }
  } catch(\Exception $ex) {
    return $response->withJson(array('error' => $ex->getMessage()), 422);
  }
});

// Return list of warnings.
$app->get('/v1/select/warnings', function ($request, $response) {

  $sth = $this->dbm2->prepare("SELECT row_id, description FROM warning");

  try {
    $sth->execute();
    $result = $sth->fetchAll();

    return $response->withJson($result, 200);

  } catch(\Exception $ex){
    return $response->withJson(array('error' => "Failed to get warnings: " . $ex->getMessage()), 422);
  }
});
