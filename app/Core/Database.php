<?php
namespace App\Core;

use PDO;
use PDOException;

class Database {
    private static ?PDO $pdo = null;

    public static function connect(): PDO {
        if (self::$pdo === null) {
            $config = require __DIR__ . '/../../config/config.php';

            try {
                self::$pdo = new PDO(
                    "mysql:host={$config['db']['host']};dbname={$config['db']['name']}",
                    $config['db']['user'],
                    $config['db']['pass'],
                    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
                );
            } catch (PDOException $e) {
                die("Database Connection Failed: " . $e->getMessage());
            }
        }
        return self::$pdo;
    }
}
