<?php

namespace controllers;

use Models\Category;

class CategoryController
{
  public function getCategories()
  {
    echo Category::all($_GET)->toJson();
  }

  public function getCategory()
  {
    echo Category::find($_GET)?->toJson();
  }

  public function createCategory()
  {
    Category::create($_POST);
  }

  public function updateCategory()
  {
    $data = file_get_contents('php://input');
    $data = json_decode($data, true);

    Category::update($_GET['id'], $data);
  }

  public function deleteCategory()
  {
    Category::delete($_GET['id']);
  }
}