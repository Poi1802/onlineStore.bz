<?php

namespace controllers;

use Models\Order;

class OrderController
{
  public function getOrders()
  {
    echo Order::all($_GET)->toJson();
  }

  public function getOrder()
  {
    echo Order::find($_GET['id'])?->toJson();
  }

  public function createOrder()
  {
    Order::create($_POST);
  }

  public function updateOrder()
  {
    $data = file_get_contents('php://input');
    $data = json_decode($data, true);

    Order::update($_GET['id'], $data);
  }

  public function deleteOrder()
  {
    Order::delete($_GET['id']);
  }
}