<?php

namespace App\Core;

use PDO;
use PDOException;

class Db extends PDO
{
    private static $instance;
    protected string $fetchClass = '';
    private function __construct()
    {
        try {

            parent::__construct(DNS, DB_USER, DB_PASS, DB_OPTIONS);
        } catch (PDOException $e) {
            debugPrint("Database ERROR Failed " . $e->getMessage(), true);
        }
    }

    public static function getPDO(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}
