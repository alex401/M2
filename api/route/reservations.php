<?php

$app->get('/v1/reservations/products/{name}', function ($request, $response, $args) {
  $nameParam = $request->getAttribute('name');
  $name = "%".$nameParam."%";

  $sth = $this->dbdoll->prepare(
    "SELECT ref, label
    FROM llx_product
    WHERE label like :name"
  );
  $sth->bindParam(':name', $name, PDO::PARAM_STR);

  try {
    $sth->execute();
    $result = $sth->fetchAll();
  } catch(\Exception $ex) {
    return $response->withJson(array('error' => "Product search by name failed: " . $ex->getMessage()), 422);
  }

  return $response->withJson($result, 200);
});

$app->post('/v1/reservations/', function ($request, $response, $args) {
  $reservation = $request->getParsedBody();

  try {
      $this->dbm2->beginTransaction();

      $sth = $this->dbm2->prepare(
        "INSERT INTO reservation (product, contact, startDate, endDate, quantity) VALUES (:product, :contact, :startDate, :endDate, :quantity)"
      );
      $sth->bindParam(':product', $reservation['product'], PDO::PARAM_STR);
      $sth->bindParam(':contact', $reservation['contact'], PDO::PARAM_STR);
      $sth->bindParam(':startDate', $reservation['startDate'], PDO::PARAM_STR);
      $sth->bindParam(':endDate', $reservation['endDate'], PDO::PARAM_STR);
      $sth->bindParam(':quantity', $reservation['quantity'], PDO::PARAM_INT);
      $succes = $sth->execute();

      $this->dbm2->commit();
    } catch(\Exception $ex){
      $this->dbm2->rollback();
      return $response->withJson(array('error' => $ex->getMessage()), 422);
    }
});

$app->get('/v1/reservations/', function ($request, $response, $args) {
  $sth = $this->dbm2->prepare(
    "SELECT *
    FROM reservation
    ORDER BY rowid desc"
  );

  try {
    $sth->execute();
    $result = $sth->fetchAll();
  } catch(\Exception $ex) {
    return $response->withJson(array('error' => "Failed to get reservations: " . $ex->getMessage()), 422);
  }

  return $response->withJson($result, 200);
});


$app->get('/v1/reservations/{id}', function ($request, $response, $args) {
  $id = $request->getAttribute('id');

  $sth = $this->dbm2->prepare(
    "SELECT *
    FROM reservation
    WHERE rowid=:id"
  );
  $sth->bindParam(':id', $id, PDO::PARAM_INT);

  try {
    $sth->execute();
    $result = $sth->fetch();
  } catch(\Exception $ex) {
    return $response->withJson(array('error' => "Failed to get reservation " .$id. ": " . $ex->getMessage()), 422);
  }

  return $response->withJson($result, 200);
});

$app->delete('/v1/reservations/{id}', function ($request, $response, $args) {
  $id = $request->getAttribute('id');

  try {
    $this->dbm2->beginTransaction();

    $sth = $this->dbm2->prepare(
      "DELETE
      FROM reservation
      WHERE rowid=:id"
    );
    $sth->bindParam(':id', $id, PDO::PARAM_INT);

    $sth->execute();
  } catch(\Exception $ex) {
    $this->dbm2->rollback();
    return $response->withJson(array('error' => "Failed to delete reservation: " . $ex->getMessage()), 422);
  }

  return $response->withJson($id, 200);
});


$app->post('/v1/reservations/{id}', function ($request, $response, $args) {
  $id = $request->getAttribute('id');
  $reservation = $request->getParsedBody();

  try {
    $this->dbm2->beginTransaction();

    $sth = $this->dbm2->prepare(
      "UPDATE reservation
      SET product = :product, contact = :contact, startDate = :startDate, endDate = :endDate, quantity = :quantity, missing = :missing
      WHERE rowid = :id"
    );
    $sth->bindParam(':id', $id, PDO::PARAM_INT);
    $sth->bindParam(':product', $reservation['product'], PDO::PARAM_STR);
    $sth->bindParam(':contact', $reservation['contact'], PDO::PARAM_STR);
    $sth->bindParam(':startDate', $reservation['startDate'], PDO::PARAM_STR);
    $sth->bindParam(':endDate', $reservation['endDate'], PDO::PARAM_STR);
    $sth->bindParam(':quantity', $reservation['quantity'], PDO::PARAM_INT);
    $sth->bindParam(':missing', $reservation['missing'], PDO::PARAM_STR);

    $sth->execute();
  } catch(\Exception $ex) {
    $this->dbm2->rollback();
    return $response->withJson(array('error' => "Failed to update reservation ".$id.": " . $ex->getMessage()), 422);
  }

  return $response->withJson($id, 200);
});

$app->get('/v1/reservations/missing/', function ($request, $response, $args) {
  $sth = $this->dbm2->prepare(
    "SELECT *
    FROM reservation
    WHERE missing=1
    ORDER BY rowid desc"
  );

  try {
    $sth->execute();
    $result = $sth->fetchAll();
  } catch(\Exception $ex) {
    return $response->withJson(array('error' => "Failed to get missing reservations: " . $ex->getMessage()), 422);
  }

  return $response->withJson($result, 200);
});