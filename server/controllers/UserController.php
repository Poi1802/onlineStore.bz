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
}