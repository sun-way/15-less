<?php
abstract class Connection
{
    /**
     * Возвращает подключение к БД
     * @return PDO
     */
    protected function getConnection()
    {
        $host = HOST;
        $db = DB;
        $connect = new PDO(
            "mysql:host=$host;dbname=$db;charset=utf8",
            USER,
            PASS,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        ) or die('Cannot connect to MySQL server :(');
        return $connect;
    }
}