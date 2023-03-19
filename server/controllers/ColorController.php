<?php

namespace controllers;

use Models\Color;

class ColorController
{
  public function getColors()
  {
    echo Color::all($_GET)->toJson();
  }

  public function getColor()
  {
    echo Color::find($_GET)?->toJson();
  }

  public function createColor()
  {
    Color::create($_POST);
  }

  public function updateColor()
  {
    $data = file_get_contents('php://input');
    $data = json_decode($data, true);

    Color::update($_GET['id'], $data);
  }

  public function deleteColor()
  {
    Color::delete($_GET['id']);
  }
}