<?php

namespace App\Utils;

class Database {
    public static function testv1($h, $u, $pw, $db, $pr = 3306) {
        $host = "{$h}:{$pr}";
        $username = $u;
        $password = $pw;
        $database = $db;

        try {
            $connection = new \mysqli($host, $username, $password, $database);
            if ($connection->connect_error) {
                throw new mysqli_sql_exception('Connection error: ' . $connection->connect_error);
            }

            return [
                'connection' => true,
                'message' => ''
            ];
        } catch(mysqli_sql_exception $e) {
            return [
                'connection' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}
