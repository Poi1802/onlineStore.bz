<?php

namespace controllers;

use Models\Brand;

class BrandController
{
  public function getBrands()
  {
    echo Brand::all($_GET)->toJson();
  }

  public function getBrand()
  {
    echo Brand::find($_GET)?->toJson();
  }

  public function createBrand()
  {
    Brand::create($_POST);
  }

  public function updateBrand()
  {
    $data = file_get_contents('php://input');
    $data = json_decode($data, true);

    Brand::update($_GET['id'], $data);
  }

  public function deleteBrand()
  {
    Brand::delete($_GET['id']);
  }
}