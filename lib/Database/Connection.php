<?php
namespace Database;

abstract class Connection
{
  private static $conn;

  public static function connect()
  {
    if(!self::$conn) {
      self::$conn = new \PDO('mysql: host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
    }

    return self::$conn;
  }

}