<?php

namespace controllers;

use Models\Favorite;

class FavoriteController
{
  public function getFavorites()
  {
    echo Favorite::all($_GET)->toJson();
  }

  public function getFavorite()
  {
    echo Favorite::find($_GET)?->toJson();
  }

  public function createFavorite()
  {
    Favorite::create($_POST);
  }

  public function updateFavorite()
  {
    $data = file_get_contents('php://input');
    $data = json_decode($data, true);

    Favorite::update($_GET['id'], $data);
  }

  public function deleteFavorite()
  {
    Favorite::delete($_GET['id']);
  }
}