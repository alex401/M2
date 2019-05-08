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
    WHERE rowid <=109 AND rowid >= 82 AND rowid >= 282 AND rowid <=322 OR rowid >=1168 AND rowid <=1309
    ORDER BY color;"
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
