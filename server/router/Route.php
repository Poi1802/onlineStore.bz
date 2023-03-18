<?php
namespace router;


class Route
{
  /**
   * @property array $controller
   * @property string $path
   */
  public static function get(string $path, array $controller)
  {
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
      return;
    }
    if ($path !== $_SERVER['REDIRECT_URL']) {
      return;
    }

    $method = $controller[1];

    $action = new $controller[0];
    $action->$method();

  }

  public static function post(string $path, array $controller)
  {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      return;
    }
    if ($path !== $_SERVER['REDIRECT_URL']) {
      return;
    }

    $method = $controller[1];

    $action = new $controller[0];
    $action->$method();

  }

  public static function patch(string $path, array $controller)
  {
    if ($_SERVER['REQUEST_METHOD'] !== 'PATCH') {
      return;
    }
    if ($path !== $_SERVER['REDIRECT_URL']) {
      return;
    }

    $method = $controller[1];

    $action = new $controller[0];
    $action->$method();

  }

  public static function delete(string $path, array $controller)
  {
    if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
      return;
    }
    if ($path !== $_SERVER['REDIRECT_URL']) {
      return;
    }

    $method = $controller[1];

    $action = new $controller[0];
    $action->$method();

  }
}