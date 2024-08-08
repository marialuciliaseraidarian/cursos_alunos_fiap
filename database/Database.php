<?php

namespace Database;

require_once __DIR__ . "/config.php";

class Database
{
    private static $conn = null;

    public static function getConnection()
    {
        if (self::$conn === null) {
            require_once __DIR__ . "/config.php";
            self::$conn = new \mysqli(HOST, USER, PASS, BASE);
            if (self::$conn->connect_error) {
                die("Conexão falhou: " . self::$conn->connect_error);
            }
        }
        return self::$conn;
    }
}
