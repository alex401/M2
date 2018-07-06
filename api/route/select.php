<?php

// return list of all categories
$app->get('/v1/select/categories', function ($request,$response) {

$sth = $this->dbdoll->prepare('SELECT rowId, label FROM llx_categorie WHERE type=2 ORDER BY label');

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

// return a list of tags
$app->get('/v1/select/entreeservice/tags', function ($request,$response, $args) {

$sth = $this->dbdoll->prepare("SELECT rowid, label, color, 'false' as checked FROM `llx_categorie` WHERE rowid <=109 AND rowid >= 82 or rowid >= 282 and rowid <=322 or rowid >=1168 and rowid <=1309 order by color;");

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

// return a list of formation

$app->get('/v1/select/formations', function ($request,$response) {

$sth = $this->dbdoll->prepare("SELECT rowId, intitule FROM llx_agefodd_formation_catalogue WHERE archive=0 AND intitule != '' ORDER BY intitule");

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
