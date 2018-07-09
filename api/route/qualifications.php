<?php

//******************************
// Qualifications
//-----------------
//
//
//
//******************************

$app->post('/v1/form/qualifications/{socpeopleid}', function ($request, $response, $args) {

  $socpeopleid = $args['socpeopleid'];
  $typeCommande = "qualifications";
  $data = $request->getParsedBody();
  //$data = (json_encode($data));

  //init vars at 0
  $count = 0;
  $sum = 0;

  //transform number into text and build average to define TAG
  foreach($data as $key => $field) {
    if(is_numeric($field)) {
      $count = $count +1;
      $sum = $sum + $field;
      $field = getnote($field);
    }
    $temp[$key] =  $field;
  }
  //calculate $average
  $average = $sum/$count;

  //CASE to get TAG color
  $tag = getTag($average);

  //Get rowid of tag
  $sth = $this->dbdoll->prepare("SELECT rowid from llx_categorie WHERE label='$tag';");

  try {
    $sth->execute();
    $result = $sth->fetchAll();

  } catch(\Exception $ex) {
    return $response->withJson(array('error' => $ex->getMessage()), 422);
  }
  $tagid = $result[0]['rowid'];

  // Verify that the soc_people is not already tagged.
  $sth = $this->dbdoll->prepare("SELECT fk_categorie, fk_socpeople FROM llx_categorie_contact WHERE fk_socpeople = $socpeopleid AND fk_categorie = $tagid;");

  try {
    $sth->execute();
    $result = $sth->fetchAll();
  } catch(\Exception $ex) {
    return $response->withJson(array('error' => $ex->getMessage()), 422);
  }

  if($result) {
    return $response->withJson(array('status' => 'OKAY'), 200);
  } else {
    //Insert tags into dollibar
    $sth = $this->dbdoll->prepare("INSERT INTO `llx_categorie_contact`(`fk_categorie`, `fk_socpeople`) VALUES ($tagid, $socpeopleid)");
    try {
      $sth->execute();
    } catch(\Exception $ex) {
      return $response->withJson(array('error' => $ex->getMessage()), 422);
    }

    // Log and send qualifications by email.
    $name = $data["Nom de l'astreint: "];
    $data = (json_encode($temp));

    //append to file named year-month
    $result = setContent("qualifications-" . $name, $data);
    $mail = mailSender("qualifications-" . $name, $data, "sud.commandement@pci-fr.ch", "sud.fourrier@pci-fr.ch");

    //if someting was inserted
    if($result > 1 & $mail == 0) {
      return $response->withJson(array('status' => 'OK'), 200);
    } else {
      return $response->withJson(array('status' => "Erreur pendant l'envoi de l'email."), 422);
    }
  }
});


//UTILS

//return text based on number
function getnote($num)
{
	switch ($num) {
		case 1 : return 'Insuffisant';
		case 3 : return 'Suffisant';
		case 4 : return 'Bon';
		case 5 : return 'Tres bon';
	}
}

//return tag based on range
function getTag($num)
{
  if ($num >= 1 && $num <=2){
    return "rouge";
  } elseif ($num > 2 && $num <=4) {
    return "orange";
  } elseif ($num >4) {
    return "vert";
  }

}
