<?php
namespace database;

use traits\DefaultStart;

abstract class Model
{
  use DefaultStart;

  protected $table = '';

  static $queryResult;

  public static function all($params = [], $columns = ['*'])
  {
    /**
     * return $column, $param, $pdo
     */
    $startArr = (new static )->start($params, $columns);
    extract($startArr);

    $table = (new static )->table;

    $sql = "SELECT $column FROM $table $param";

    $query = $pdo->prepare($sql);
    $query->execute();
    $res = $query->fetchAll();

    if (!isset($res)) {
      http_response_code(404);

      echo json_encode([
        'status' => false,
        'message' => "There are no columns in the table $table"
      ]);
    } else {
      return new Builder($res);
    }
  }

  public static function find($id, $columns = ['*'])
  {
    /**
     * return $column, $param, $pdo
     */
    $startArr = (new static )->start([], $columns);
    extract($startArr);

    $table = (new static )->table;

    $sql = "SELECT $column FROM $table WHERE id=$id";

    $query = $pdo->prepare($sql);
    $query->execute();
    $res = $query->fetch();

    if (!$res) {
      http_response_code(404);

      echo json_encode([
        'status' => false,
        'message' => "There are no column with id=$id in the table $table"
      ]);
    } else {
      return new Builder($res);
    }
  }
}