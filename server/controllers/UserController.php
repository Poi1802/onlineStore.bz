<?php

namespace controllers;

use Models\User;

class UserController
{
  public function getUsers()
  {
    echo User::all()->toJson();
  }
}