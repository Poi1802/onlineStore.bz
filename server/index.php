<?php
require_once('./vendor/autoload.php');
require_once('./headers.php');

use controllers\UserController;

$url = $_SERVER['REQUEST_URI'];

if ($url === '/server/users') {
  include('./controllers/UserController.php');
  $controller = new UserController();
  $controller->getUsers();
}