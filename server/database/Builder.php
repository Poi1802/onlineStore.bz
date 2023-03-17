<?php

namespace database;

class Builder
{
  protected $data;

  /**
   * Class constructor.
   */
  public function __construct($res)
  {
    $this->data = $res;
  }

  public function toArray()
  {
    return $this->data;
  }

  public function toJson()
  {
    return json_encode($this->data);
  }

  public function where($operator, $value)
  {
    if (!array_key_exists($operator, $this->data[0])) {
      return $this;
    }

    // print_r($_SERVER);

    $this->data = array_filter($this->data, fn($item) => $item[$operator] === $value);
    return $this;

  }
}