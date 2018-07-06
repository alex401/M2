<?php


$app->get('/v1/chantiers', function ($request,$response) {

    try{

//TODO connection to DB  GET data from llx_projet

$sth = $this->dbdoll->prepare("SELECT `rowid`, `title`, `date_close` FROM `llx_projet`;");

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
