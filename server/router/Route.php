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
      return 'GET method pls!';
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
      return 'POST method pls!';
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
      return 'POST method pls!';
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
      return 'POST method pls!';
    }
    if ($path !== $_SERVER['REDIRECT_URL']) {
      return;
    }

    $method = $controller[1];

    $action = new $controller[0];
    $action->$method();

  }
}