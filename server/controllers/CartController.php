<?php

namespace controllers;

use Models\Cart;

class CartController
{
  public function getCarts()
  {
    echo Cart::all($_GET)->toJson();
  }

  public function getCart()
  {
    echo Cart::find($_GET)?->toJson();
  }

  public function createCart()
  {
    Cart::create($_POST);
  }

  public function updateCart()
  {
    $data = file_get_contents('php://input');
    $data = json_decode($data, true);

    Cart::update($_GET['id'], $data);
  }

  public function deleteCart()
  {
    Cart::delete($_GET['id']);
  }
}