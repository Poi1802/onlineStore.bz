<?php

namespace controllers;

use Models\Device;

class DeviceController
{
  public function getDevices()
  {
    echo Device::all($_GET)->toJson();
  }

  public function getDevice()
  {
    echo Device::find($_GET['id'])?->toJson();
  }

  public function createDevice()
  {
    Device::create($_POST);
  }

  public function updateDevice()
  {
    $data = file_get_contents('php://input');
    $data = json_decode($data, true);

    Device::update($_GET['id'], $data);
  }

  public function deleteDevice()
  {
    Device::delete($_GET['id']);
  }
}