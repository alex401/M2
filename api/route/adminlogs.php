<?php
$app->post('/v1/adminlogs/creation/', function ($request,$response) {
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
      $sth = $this->dbm2->prepare("INSERT INTO utilisateursformulaires SET login='" . $loginUtilisateurFormulaire . "', motdepasse='" . md5($motDePasseUtilisateurFormulaire) . "', email='" . $emailUtilisateurFormulaire . "', nom='" . $nomUtilisateurFormulaire . "', prenom='" . $prenomUtilisateurFormulaire . "'");

          try{
            $sth->execute();
          } catch(\Exception $ex){
            return $response->withJson(array('error' => $ex->getMessage()), 422);
          }
          return $response->withJson(array('status' => 'OK'), 200);


  });

?>
