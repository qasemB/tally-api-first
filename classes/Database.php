<?php

class DB
{
    private static function connect()
    {
        $pdo = new PDO('mysql:host=localhost;dbname=tally_api', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;
    }

    public static function query($query, $params = [])
    {
        $stmt = self::connect()->prepare($query);
        $stmt->execute($params);
        if (strtolower(explode(' ', $query)[0]) == 'select') {
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        }
    }
}
