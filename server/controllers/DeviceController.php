<?php
namespace controllers;

include "./paths.php";

use Models\Device;

class DeviceController
{
  public function getDevices()
  {
    echo Device::all($_GET)->toJson();
  }

  public function getDevice()
  {
    echo Device::find($_GET)?->toJson();
  }

  public function createDevice()
  {
    print_r($_FILES);
    $uploadedImg = [];

    if (!empty($_FILES)) {
      foreach ($_FILES as $file) {
        $img = time() . '_' . $file['name'];
        $tmp = $file['tmp_name'];
        $dest = ROOT_PATH . '\\assets\\devices\\' . $img;
        array_push($uploadedImg, $img);

        move_uploaded_file($tmp, $dest);
      }
    }

    $_POST['img'] = implode(',', $uploadedImg);

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