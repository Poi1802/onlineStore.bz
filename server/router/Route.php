<?php
namespace router;


class Route
{
  /**
   * @property array $controller
   */
  public static function get(string $path, array $controller)
  {
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
      exit('GET method pls!');
    }

    $url = $_SERVER['REDIRECT_URL'];
    $method = $controller[1];

    if ($url === $path) {
      $action = new $controller[0];
      $action->$method();
    }
  }
}