<?php

namespace controllers;

use Models\Type;

class TypeController
{
  public function getTypes()
  {
    echo Type::all($_GET)->toJson();
  }

  public function getType()
  {
    echo Type::find($_GET)?->toJson();
  }

  public function createType()
  {
    Type::create($_POST);
  }

  public function updateType()
  {
    $data = file_get_contents('php://input');
    $data = json_decode($data, true);

    Type::update($_GET['id'], $data);
  }

  public function deleteType()
  {
    Type::delete($_GET['id']);
  }
}