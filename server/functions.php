<?php
require_once __DIR__ . '/connections.php';

function dump($val)
{
  print_r($val);
  exit(' DUMP');
}

function getTable($db, $params = [])
{
  global $pdo;

  $sql = "SELECT * FROM $db";

  if (!empty($params)) {
    $i = 0;
    foreach ($params as $key => $val) {
      if ($i === 0) {
        $sql .= " WHERE $key = :$key";
      } else {
        $sql .= " AND $key = :$key";
      }
    }
  }

  // dump($sql);

  $query = $pdo->prepare($sql);
  $query->execute($params);
  $data = $query->fetchAll();

  echo json_encode($data);
}

function getRowOfTable($db, $params = [])
{
  global $pdo;

  $sql = "SELECT * FROM $db";

  if (!empty($params)) {
    $i = 0;
    foreach ($params as $key => $val) {
      if ($i === 0) {
        $sql .= " WHERE $key=$val";
      } else {
        $sql .= " AND $key=$val";
      }
      $i++;
    }
  } else {
    echo json_encode([
      'status' => 'NO_PARAMETR'
    ]);
  }

  $query = $pdo->prepare($sql);
  $query->execute();
  $data = $query->fetch();

  echo json_encode($data);
}

function updateRow($db, $id, $data = [])
{
  // UPDATE `users` SET `name`='Andr' WHERE `id`=2; 
  global $pdo;
  $updates = '';

  if (!empty($data)) {
    foreach ($data as $key => $val) {
      if ($updates === '') {
        $updates .= "$key = :$key";
      } else {
        $updates .= ", $key = :$key";
      }
    }
  } else {
    echo json_encode([
      'data' => 'NO_DATA'
    ]);
    exit();
  }

  $sql = "UPDATE $db SET $updates WHERE id = $id";

  $query = $pdo->prepare($sql);
  $query->execute($data);

  echo json_encode([
    'status' => true,
    'message' => "$db where id=$id is updated",
  ]);
}

function insertRow($db, $data)
{
  global $pdo;

  $structure = '';
  $values = '';

  foreach ($data as $key => $value) {
    if ($structure === '' && $values === '') {
      $structure .= $key;
      $values .= ':' . $key;
    } else {
      $structure .= ', ' . $key;
      $values .= ', :' . $key;
    }
  }

  $query = $pdo->prepare("INSERT INTO $db($structure) VALUES ($values)");
  $query->execute($data);

  echo json_encode([
    'status' => true,
    'post_id' => "created $db with id = " . $pdo->lastInsertId(),
  ]);
}

function deleteRow($db, $id)
{
  // DELETE FROM `users` WHERE `id` = 3 
  global $pdo;

  $query = $pdo->prepare("DELETE FROM $db WHERE id=$id");
  $query->execute();

  echo json_encode([
    'status' => true,
    'message' => "$db with id=$id deleted",
  ]);
}