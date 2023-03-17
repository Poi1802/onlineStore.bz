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
    $startArr = (new static )->startGet($params, $columns);
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
    $startArr = (new static )->startGet([], $columns);
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

  public static function create(array $data)
  {
    /**
     * return $structure, $values, $pdo
     */
    extract((new static )->startPost($data));

    $table = (new static )->table;

    $sql = "INSERT INTO $table($structure) VALUES($values)";

    $query = $pdo->prepare($sql);
    $query->execute($data);

    echo json_encode([
      'status' => true,
      'message' => "created in $table with id = " . $pdo->lastInsertId(),
      'created_id' => $pdo->lastInsertId()
    ]);
  }

  public static function update(int $id, array $data)
  {
    /**
     * return $updates, $pdo
     */
    extract((new static )->startPatch($data));

    $table = (new static )->table;

    $sql = "UPDATE $table SET $updates WHERE id=$id";

    $query = $pdo->prepare($sql);
    $query->execute($data);

    echo json_encode([
      'status' => true,
      'message' => "updated in $table with id = " . $id,
      'updated_id' => $id
    ]);
  }

  public static function delete(int $id)
  {
    $pdo = (new Connection())->getObj();

    $table = (new static )->table;

    $sql = "DELETE FROM $table WHERE id=$id";

    $pdo->prepare($sql)->execute();

    echo json_encode([
      'status' => true,
      'message' => "Object in $table with id=$id deleted",
      'deleted_id' => $id
    ]);
  }
}