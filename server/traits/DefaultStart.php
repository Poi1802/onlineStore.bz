<?php

namespace traits;

use database\Connection;

/**
 * 
 */
trait DefaultStart
{
  protected function start($params = [], $columns = ['*'])
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
          $param .= "AND $key=$val";
        }
      }
    }

    return compact(['pdo', 'column', 'param']);
  }
}