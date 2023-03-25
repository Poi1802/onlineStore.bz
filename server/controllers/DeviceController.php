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
    echo Device::find($_GET)->toJson();
  }

  public function createDevice()
  {
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

    if (!empty($_POST)) {
      $_POST['img'] = implode(',', $uploadedImg);

      Device::create($_POST);
    }
  }

  public function addImgToDevice()
  {
    print_r(explode(',', $_POST['img']));
    print_r($_FILES);
    if (!empty($_FILES)) {
      $uploadedImg = isset($_POST['img']) ? explode(',', $_POST['img']) : [];

      foreach ($_FILES as $file) {
        $img = time() . '_' . $file['name'];
        $tmp = $file['tmp_name'];
        $dest = ROOT_PATH . '\\assets\\devices\\' . $img;
        array_push($uploadedImg, $img);

        move_uploaded_file($tmp, $dest);
      }

      Device::update($_GET['id'], ['img' => implode(',', $uploadedImg)]);
    }
  }

  public function updateDevice()
  {
    $data = file_get_contents('php://input');
    $data = json_decode($data, true);

    Device::update($_GET['id'], $data);
  }

  public function deleteDevice()
  {
    if (!empty($_GET['img'])) {
      $imgs = explode(',', $_GET['img']);
      $dest = ROOT_PATH . '\\assets\\devices\\';
      foreach ($imgs as $img) {
        unlink($dest . $img);
      }
    }

    Device::delete($_GET['id']);
  }
}