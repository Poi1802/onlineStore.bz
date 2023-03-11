<?php
require_once './connections.php';

function getTable($db)
{
  global $pdo;

  $query = $pdo->prepare("SELECT * FROM $db");
  $query->execute();
  $data = $query->fetchAll();

  echo json_encode($data);
}

function getTableRow($db, $id)
{
  global $pdo;

  $query = $pdo->prepare("SELECT * FROM $db WHERE id = $id");
  $query->execute();
  $data = $query->fetch();

  echo json_encode($data);
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
    'post_id' => $pdo->lastInsertId(),
  ]);
}