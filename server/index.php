<?php
require_once './functions.php';

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *, Authorization');
header('Access-Control-Allow-Methods: *');
header('Access-Control-Allow-Credentials: true');
header('Content-type: json/application');

$method = $_SERVER['REQUEST_METHOD'];

$q = $_GET['q'];
$params = explode('/', $q);
$type = $params[0];
$id = isset($params[1]) ? $params[1] : 0;

if ($method === 'GET') {
  if ($id !== 0 && $id !== '') {
    getTableRow($type, $id);
  } else {
    getTable($type);
  }
} elseif ($method === 'POST') {
  if ($type !== '') {
    insertRow($type, $_POST);
  }
}