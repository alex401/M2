<?php

// Delete a particular warning.
$app->delete('/v1/superadmin/warning/{id}', function($request, $response, $args) {

    $warningId = $args['id'];

    $sth = $this->dbm2->prepare(
      "DELETE FROM `warning` WHERE `warning`.`row_id` = $warningId"
    );

    try {
      $sth->execute();
      return $response->withJson($warningId, 200);
    } catch(\Exception $ex) {
      return $response->withJson(array('error' => "Failed to delete warning with id $warningId: " . $ex->getMessage()), 422);
    }
});

// Update a warning.
$app->put('/v1/superadmin/warning/{id}', function($request, $response, $args) {

    $warningId = $args['id'];

    $data = $request->getParsedBody();
    $data = (json_encode($data));
    $data = json_decode($data, true);

    $description = $data['description'];

    $sth = $this->dbm2->prepare(
      "UPDATE `warning` SET `description` = :description WHERE `warning`.`row_id` = $warningId"
    );
    $sth->bindParam(':description', $description, PDO::PARAM_STR);

    try {
      $sth->execute();
      return $response->withJson($warningId, 200);
    } catch(\Exception $ex) {
      return $response->withJson(array('error' => "Failed to update warning with id $warningId: " . $ex->getMessage()), 422);
    }
});

// Create a new warning.
$app->post('/v1/superadmin/warning', function($request, $response) {

    $data = $request->getParsedBody();
    $data = (json_encode($data));
    $data = json_decode($data, true);

    $description = $data['description'];

    $sth = $this->dbm2->prepare(
      "INSERT INTO `warning` (`row_id`, `description`) VALUES (NULL, :description)"
    );
    $sth->bindParam(':description', $description, PDO::PARAM_STR);

    try {
      $result = $sth->execute();
      return $response->withJson($result, 200);
    } catch(\Exception $ex) {
      return $response->withJson(array('error' => "Failed to create new warning: " . $ex->getMessage()), 422);
    }
});

$app->post('/v1/superadmin/login', function ($request,$response) {
    //TODO contrôle de saisie

    $data = $request->getParsedBody();
    $data = (json_encode($data));
    $data = json_decode($data, true);

    $erreur = "";

    $loginUtilisateurFormulaire = $data['login'];
    $motDePasseUtilisateurFormulaire = $data['motdepasse'];
    $emailUtilisateurFormulaire = $data['email'];
    $nomUtilisateurFormulaire = $data['nom'];
    $prenomUtilisateurFormulaire = $data['prenom'];
    $usertypeUtilisateurFormulaire = $data['usertype'];

    if ($loginUtilisateurFormulaire == '') {
        $erreur.="Veuillez saisir un login.";
       return $response->withJson($erreur, 200);
    }

    $sth = $this ->dbm2->prepare("SELECT * FROM utilisateursformulaires WHERE login='$loginUtilisateurFormulaire'");
    try {
      $sth->execute();
      $result = $sth->fetchAll();
    } catch(\Exception $ex) {
      return $response->withJson(array('error' => $ex->getMessage()), 422);
    }

    if ($result) {
        $erreur.="Login existant. Veuillez saisir un autre login.";
    }

    if ($erreur != '') {
      return $response->withJson($erreur, 200);
    }
      $sth = $this->dbm2->prepare("INSERT INTO utilisateursformulaires SET login='" . $loginUtilisateurFormulaire . "', motdepasse='" . md5($motDePasseUtilisateurFormulaire) . "', email='" . $emailUtilisateurFormulaire . "', nom='" . $nomUtilisateurFormulaire . "', prenom='" . $prenomUtilisateurFormulaire . "', usertype='" . $usertypeUtilisateurFormulaire . "'");

          try{
            $sth->execute();
          } catch(\Exception $ex){
            return $response->withJson(array('error' => $ex->getMessage()), 422);
          }
          return $response->withJson(array('status' => 'OK'), 200);
  });
