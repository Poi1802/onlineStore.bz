<?php
require_once '../paths.php';
require_once SITE_ROOT . '/headers.php';
require_once SITE_ROOT . '/functions.php';

$method = $_SERVER['REQUEST_METHOD'];
$type = 'orders';

if ($method === 'GET') {
  if (!empty($_GET['id'])) {
    getRowOfTable($type, $_GET);
  } else {
    getTable($type, $_GET);
  }
} elseif ($method === 'PATCH') {
  if (!empty($_GET['id'])) {
    // Take JSON from PATCH
    $data = file_get_contents('php://input');
    $data = json_decode($data, true);
    /* ------------------------------- */

    updateRow($type, $_GET['id'], $data);
  }
} elseif ($method === 'POST') {
  insertRow($type, $_POST);
} elseif ($method === 'DELETE') {
  deleteRow($type, $_GET['id']);
}