<?php

namespace traits;

use database\Connection;

/**
 * 
 */
trait DefaultStart
{
  protected function startGet($params = [], $columns = ['*'])
  {
    $pdo = (new Connection())->getObj();
    $column = '';

    if (count($columns) > 1) {
      foreach ($columns as $value) {
        if ($column === '') {
          $column .= $value;
        } else {
          $column .= ", $value";
        }
      }
    } else {
      $column = $columns[0];
    }

    $param = '';

    if (count($params) > 0) {
      foreach ($params as $key => $val) {
        if ($param === '') {
          $param .= "WHERE $key=$val ";
        } else {
          $param .= "AND $key=$val ";
        }
      }
    }

    return compact(['pdo', 'column', 'param']);
  }

  protected function startPost(array $data)
  {
    $pdo = (new Connection())->getObj();

    $structure = '';
    $values = '';

    foreach ($data as $key => $value) {
      if ($structure === '' && $values === '') {
        $structure .= $key;
        $values .= ":$key";
      } else {
        $structure .= ", $key";
        $values .= ", :$key";
      }
    }

    return compact(['pdo', 'structure', 'values']);
  }

  protected function startPatch(array $data)
  {
    $pdo = (new Connection())->getObj();

    $updates = '';

    foreach ($data as $key => $val) {
      if ($updates === '') {
        $updates .= "$key = :$key";
      } else {
        $updates .= ", $key = :$key";
      }
    }

    return compact(['pdo', 'updates']);
  }
}