<?php

namespace controllers;

use Models\User;

class UserController
{

  public $x = 123;
  public function getUsers()
  {
    echo User::all()->toJson();
  }

  public function getUser()
  {
    echo User::find($_GET['id'])?->toJson();
  }

  public function createUser()
  {
    User::create($_POST);
  }

  public function updateUser()
  {
    $data = file_get_contents('php://input');
    $data = json_decode($data, true);

    User::update($_GET['id'], $data);
  }

  public function deleteUser()
  {
    User::delete($_GET['id']);
  }
}