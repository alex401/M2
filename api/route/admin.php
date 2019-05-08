<?php
// Allows to only work (SELECT, DELETE) with languages present in M2. Languages from dolibarr will not be touched.
const LANGS = array('fr_FR', 'de_DE', 'en_GB', 'it_IT', 'es_ES', 'pt_PT', 'tr_TR', 'pl_PL', 'ru_RU', 'nl_NL', 'sq_AL', 'bs_BA');

// Return a list of tiers searched by name.
$app->get('/v1/admin/tiers/{name}', function ($request, $response, $args) {

  $name = $args['name'];
  $name = "%".$name."%";

  $sth = $this->dbdoll->prepare(
    "SELECT nom, address, zip, town, phone, email, url, rowid FROM llx_societe WHERE nom like :name"
  );
  $sth->bindParam(':name', $name, PDO::PARAM_STR);

  try {
    $sth->execute();
    $result = $sth->fetchAll();
  } catch(\Exception $ex) {
    return $response->withJson(array('error' => "Tiers search by name failed: " . $ex->getMessage()),422);
  }

  return $response->withJson($result, 200);
});

// Return a list of contacts searched by name.
$app->get('/v1/admin/socpeople/{name}', function ($request, $response, $args) {

  $name = $args['name'];
  $name = "%".$name."%";

  $sth = $this->dbdoll->prepare(
    "SELECT CONCAT(lastname, ' ', firstname) as nom, address, zip, town, phone, email, rowid
    FROM llx_socpeople
    WHERE CONCAT(lastname, ' ', firstname) like :name"
  );
  $sth->bindParam(':name', $name, PDO::PARAM_STR);

  try {
    $sth->execute();
    $result = $sth->fetchAll();
  } catch(\Exception $ex) {
    return $response->withJson(array('error' => "Contacts search ny name failed: " . $ex->getMessage()), 422);
  }

  return $response->withJson($result, 200);
});

// Get the parent links list.
$app->get('/v1/admin/socpeople/extra/parent', function ($request, $response) {

  $sth = $this->dbdoll->prepare("SELECT code, label FROM llx_c_contact_extrafields");

  try {
    $sth->execute();
    $result = $sth->fetchAll();
  } catch(\Exception $ex){
    return $response->withJson(array('error' => "Failed to obtain parent list: " . $ex->getMessage()), 422);
  }

  return $response->withJson($result, 200);
});

// Return the extra field for a soc people.
$app->get('/v1/admin/socpeople/extra/{rowid}', function ($request, $response, $args) {

  $id = $args['rowid'];

  $sth = $this->dbdoll->prepare("SELECT nb, lp FROM llx_socpeople_extrafields WHERE fk_object = $id");

  try {
    $sth->execute();
    $result = $sth->fetch();
  } catch(\Exception $ex){
    return $response->withJson(array('error' => $ex->getMessage()), 422);
  }

  return $response->withJson($result, 200);
});

// Get the tags list for a person.
$app->get('/v1/admin/tags/{personneid}', function($request, $response, $args) {

  $rowid = $args['personneid'];
  $sth = $this->dbdoll->prepare(
    "SELECT llx_categorie.rowid, llx_categorie.label, llx_categorie.color, 'true' as checked
    FROM llx_categorie_contact
    INNER JOIN llx_categorie ON llx_categorie_contact.fk_categorie = llx_categorie.rowid
    WHERE llx_categorie_contact.fk_socpeople = $rowid"
  );

  try {
    $sth->execute();
    $result = $sth->fetchAll();
  } catch(\Exception $ex){
    return $response->withJson(array('error' => "Failed to obtain tags list: " . $ex->getMessage()), 422);
  }

  return $response->withJson($result, 200);
});

// Return a list of contacts searched by tags.
$app->get('/v1/admin/socpeople/tags/{tagid}', function ($request, $response, $args) {

  $tagid = $args['tagid'];
  $tagid = "%".$tagid."%";

  $sth = $this->dbdoll->prepare(
    "SELECT CONCAT(llx_socpeople.lastname, ' ', llx_socpeople.firstname) as nom, llx_socpeople.address,
      llx_socpeople.zip, llx_socpeople.town, llx_socpeople.phone, llx_socpeople.email, llx_socpeople.rowid, b.label
    FROM llx_socpeople
    INNER JOIN (
      SELECT llx_categorie_contact.fk_socpeople, llx_categorie.label
      FROM llx_categorie_contact INNER JOIN llx_categorie
      ON llx_categorie_contact.fk_categorie = llx_categorie.rowid
      WHERE llx_categorie.label LIKE :tagid
    ) b ON llx_socpeople.rowid = b.fk_socpeople"
  );
  $sth->bindParam(':tagid', $tagid, PDO::PARAM_STR);

  try {
    $sth->execute();
    $result = $sth->fetchAll();
  } catch(\Exception $ex){
    return $response->withJson(array('error' => "Contacts search by tag failed: " . $ex->getMessage()), 422);
  }

  return $response->withJson($result, 200);
});

$app->post('/v1/admin/listeappel', function ($request,$response) {

  $typeCommande = "Appel";
  $data = $request->getParsedBody();
  $data = (json_encode($data));

  try {
    //append to file named year-month
    $result = setContent($typeCommande, $data);
    $mail = mailSenderComplex($typeCommande, $data, "sud.commandement@pci-fr.ch", "sud.fourrier@pci-fr.ch");
    //if someting was inserted
    if($result) {
      return $response->withJson(array('status' => 'OK'), 200);
    } else {
      return $response->withJson(array('status' => 'Erreur pendant commande de'+ $typeCommande),422);
    }
  } catch(\Exception $ex){
    return $response->withJson(array('error' => $ex->getMessage()),422);
  }
});

$app->post('/v1/admin/entreeservice/tags/{personneid}', function ($request, $response, $args) {

  $result  = "";
  $personneid = $args['personneid'];
  $data = $request->getParsedBody();
  $data = (json_encode($data));
  $data = json_decode($data, true);

  //TODO array_key_exists() ?
  $dataLieu = $data['lieu'];
  $dataAdresse = $data['adresse'];
  $dataZip = $data['zip'];
  $dataMail = $data['mail'];
  $dataPhone = $data['phone'];
  $dataUrgence = $data['urgence'];
  $dataParent = $data['parent'];

  try {
    // Update info.
    $sth = $this->dbdoll->prepare(
      "UPDATE llx_socpeople
      SET town = :dataLieu, address = :dataAdresse, zip = :dataZip, email = :dataMail, phone = :dataPhone
      WHERE rowid = $personneid"
    );
    $sth->bindParam(':dataLieu', $dataLieu, PDO::PARAM_STR);
    $sth->bindParam(':dataAdresse', $dataAdresse, PDO::PARAM_STR);
    $sth->bindParam(':dataZip', $dataZip, PDO::PARAM_STR);
    $sth->bindParam(':dataMail', $dataMail, PDO::PARAM_STR);
    $sth->bindParam(':dataPhone', $dataPhone, PDO::PARAM_STR);
    $sth->execute();

    $sth = $this->dbdoll->prepare(
      "UPDATE llx_societe, llx_socpeople
      SET llx_societe.address = :dataAdresse, llx_societe.zip = :dataZip, llx_societe.town = :dataLieu,
        llx_societe.email = :dataMail, llx_societe.phone = :dataPhone
      WHERE llx_societe.rowid = llx_socpeople.fk_soc AND llx_socpeople.rowid = $personneid"
    );
    $sth->bindParam(':dataLieu', $dataLieu, PDO::PARAM_STR);
    $sth->bindParam(':dataAdresse', $dataAdresse, PDO::PARAM_STR);
    $sth->bindParam(':dataZip', $dataZip, PDO::PARAM_STR);
    $sth->bindParam(':dataMail', $dataMail, PDO::PARAM_STR);
    $sth->bindParam(':dataPhone', $dataPhone, PDO::PARAM_STR);
    $sth->execute();

  } catch (\Exception $ex) {
    return $response->withJson(array('error' => 'Failed to update info: ' . $ex->getMessage()), 422);
  }

  // Update tags.
  $newTags = $data['tagged'];
  $toDeleteTags = [];

  // Get all current tags for the person.
  try {
    $sth = $this->dbdoll->prepare(
      "SELECT fk_categorie, fk_socpeople
      FROM llx_categorie_contact
      WHERE fk_socpeople = $personneid"
    );
    $sth->execute();
    $toDeleteTags = $sth->fetchAll();

  } catch(\Exception $ex) {
    return $response->withJson(array('error' => 'Failed to find tags: ' . $ex->getMessage()), 422);
  }

  // Compare and update arrays so they contain tags to add and tags to delete.
  foreach ($newTags as $key => $value) {
    $tagid =  $value['rowid'];
    $deleteIndex = -1;
    foreach($toDeleteTags as $key2 => $value2) {
      if($value2['fk_categorie'] == $tagid) {
        unset($newTags[$key]);
        unset($toDeleteTags[$key2]);
        break;
      }
    }
  }

  try {
    $this->dbdoll->beginTransaction();

    // Insert new tags.
    if(sizeof($newTags) > 0) {
      foreach ($newTags as $key => $value) {
        $tagid =  $value['rowid'];
        $sth = $this->dbdoll->prepare(
          "INSERT INTO `llx_categorie_contact`(`fk_categorie`, `fk_socpeople`) VALUES ($tagid, $personneid)"
        );
        $sth->execute();
      }
    }

    // Delete old tags.
    if(sizeof($toDeleteTags) > 0) {
      foreach ($toDeleteTags as $key => $value) {
        $tagid =  $value['fk_categorie'];
        // FIXME This has to match the query select.php./v1/select/entreeservice/tags.
        // This is done to avoid deleting tags present in Dolibarr but not yet in m2.
        if(($tagid <=109 && $tagid >= 82) || ($tagid >= 282 && $tagid <=322) || ($tagid >=1168 && $tagid <=1309)) {
          $sth = $this->dbdoll->prepare(
            "DELETE FROM `llx_categorie_contact` WHERE fk_categorie = $tagid AND fk_socpeople = $personneid"
          );
          $sth->execute();
        }
      }
    }
  } catch(\Exception $ex) {
      $this->dbdoll->rollback();
      return $response->withJson(array('error' => 'Failed to insert/delete tags: ' . $ex->getMessage()), 422);
  }
  $this->dbdoll->commit();

  // Update parent link and emergency number.
  try {
    $sth = $this->dbdoll->prepare(
      "UPDATE llx_socpeople_extrafields SET nb = :dataUrgence, lp = '$dataParent' WHERE fk_object = $personneid"
    );
    $sth->bindParam(':dataUrgence', $dataUrgence, PDO::PARAM_STR);
    $sth->execute();

  } catch(\Exception $ex) {
    return $response->withJson(array('error' => 'Failed to modify emergency data: ' . $ex->getMessage()), 422);
  }

  return $response->withJson(array('status' => 'OK'), 200);
});

// Update languages in ecv module.
$app->post('/v1/admin/entreeservice/tags/ecv/{personneid}', function ($request, $response, $args) {

  $result  = "";
  $personneid = $args['personneid'];
  $data = $request->getParsedBody();
  $data = (json_encode($data));
  $data = json_decode($data, true);

  // Get the languages.
  $data = $data['langs'];

  // Get the user fk and ecv fk.
  $sth = $this->dbdoll->prepare(
    "SELECT user.rowid as userRowid, ecv.rowid as ecvRowid
    FROM llx_user user
    JOIN llx_ecv ecv ON user.rowid = ecv.fk_user AND user.fk_socpeople = $personneid"
  );

  try {
    $sth->execute();
    $result = $sth->fetchAll();
  } catch (\Exception $ex) {
    return $response->withJson(array('error' => 'Failed to find foreign keys: ' . $ex->getMessage()), 422);
  }

  // If there is no ecv for the user, do nothing.
  if(!$result) {
    return $response->withJson(array('status' => 'No entry found in ecv. Nothing will be added.'), 200);
  }

  $userRowid = $result[0]['userRowid'];
  $ecvRowid = $result[0]['ecvRowid'];
  // For the IN clause.
  $langsStr = implode("', '", LANGS);

  try {
    $this->dbdoll->beginTransaction();

    // Retrieve previous levels since we can not set them from M2.
    $sth = $this->dbdoll->prepare(
      "SELECT rowid, name, value
      FROM `llx_ecvlangues`
      WHERE fk_user = $userRowid AND fk_ecv = $ecvRowid AND name IN('$langsStr')"
    );
    $sth->execute();
    $result = $sth->fetchAll();

    //  Delete existing entries if any.
    $sth = $this->dbdoll->prepare(
      "DELETE FROM `llx_ecvlangues` WHERE fk_user = $userRowid AND fk_ecv = $ecvRowid AND name IN('$langsStr')"
    );
    $sth->execute();

    foreach ($data as $key => $value) {
      $level = 1;
      // See if we have a previous level for the current language.
      foreach($result as &$row) {
        if($row['name'] == $value) {
          $level = $row['value'];
          break;
        }
      }

      // Add new ecv language.
      $sth = $this->dbdoll->prepare(
        "INSERT INTO `llx_ecvlangues`(`name`, `value`, `fk_ecv`, `fk_user`)
        VALUES ('$value', $level, $ecvRowid, $userRowid)"
      );
      $sth->execute();
    }

    $this->dbdoll->commit();

  } catch (\Exception $ex) {
    $this->dbdoll->rollback();
    return $response->withJson(array('error' => 'Failed to insert tags in ecv: ' . $ex->getMessage()), 422);
  }

  return $response->withJson(array('status' => 'OK'), 200);
});

// Return a list of sessions for a formation.
$app->get('/v1/admin/sessions/{formation}', function ($request, $response, $args) {

  $formation = $args['formation'];

  $sth = $this->dbdoll->prepare(
    "SELECT session.rowid, DATE_FORMAT(session.dated, '%Y-%m-%d') as 'dateDebut', DATE_FORMAT(session.datef, '%Y-%m-%d')
      as 'dateFin', socpeople.firstname, socpeople.lastname, session.fk_soc, soc.nom,
      concat(DATE_FORMAT(session.dated, '%Y-%m-%d'), ' - ', DATE_FORMAT(session.datef, '%Y-%m-%d'),' ',
      socpeople.firstname, ' ', socpeople.lastname, ' ' , soc.nom ) as 'sessionNom'
    FROM llx_societe as soc, llx_agefodd_session_formateur as sessionformateur, llx_agefodd_session as session,
      llx_agefodd_formateur as formateur, llx_socpeople as socpeople
    WHERE session.status <> 4 AND session.fk_formation_catalogue = $formation
      AND sessionformateur.fk_session = session.rowid AND sessionformateur.fk_agefodd_formateur = formateur.rowid
      AND formateur.fk_socpeople = socpeople.rowid AND session.fk_soc = soc.rowid
    ORDER BY session.dated, session.datef, session.rowid, socpeople.firstname, socpeople.lastname"
  );

  try {
    $sth->execute();
    $result = $sth->fetchAll();

    if($result) {
      return $response->withJson($result, 200);
    } else {
      return $response->withJson(array('status' => "No sessions found."), 200);
    }
  } catch(\Exception $ex){
    return $response->withJson(array('error' => "Failed to get sessions list for formation: ". $ex->getMessage()), 422);
  }
});

// Return a list of tiers searched by session.
$app->get('/v1/admin/personnes/{session}', function ($request,$response, $args) {

  $formation = $args['session'];

  $sth = $this->dbdoll->prepare(
    "SELECT stagiaire.nom, stagiaire.prenom, stagiaire.civilite, stagiaire.tel2, stagiaire.rowid, stagiaire.fk_socpeople
    FROM llx_agefodd_session_stagiaire as sessionstagiaire, llx_agefodd_stagiaire as stagiaire
    WHERE sessionstagiaire.fk_session_agefodd = $formation AND sessionstagiaire.fk_stagiaire = stagiaire.rowid
    ORDER BY stagiaire.nom, stagiaire.prenom"
  );

  try {
    $sth->execute();
    $result = $sth->fetchAll();

    if($result){
      return $response->withJson($result, 200);
    } else {
      return $response->withJson(array('status' => "No tier found for session."), 200);
    }
  } catch(\Exception $ex) {
    return $response->withJson(array('error' => "Failed to get tiers list for session: " . $ex->getMessage()),422);
  }
});
