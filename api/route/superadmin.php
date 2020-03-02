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
