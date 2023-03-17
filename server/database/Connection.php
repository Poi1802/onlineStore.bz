<?php

namespace database;

use PDO;

/**
 * Connection trait
 */
class Connection
{
  private $host = 'localhost';
  private $db = 'online_store';
  private $login = 'root';
  private $pass = '';
  private $options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
  ];
  protected $pdo;

  /**
   * Class constructor.
   */
  public function __construct()
  {
    $this->pdo = new PDO("mysql:host={$this->host};dbname={$this->db}", $this->login, $this->pass, $this->options);
  }
  public function getObj()
  {
    return $this->pdo;
  }
}