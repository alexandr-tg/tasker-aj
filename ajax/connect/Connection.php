<?php

namespace ajax\connect;

use mysql_xdevapi\Exception;

class Connection
{
    private static $instance;

    private static function getInstance()
    {
        if (!isset(self::$instance)){
            try {
                self::$instance = new \PDO("mysql:dbname=" . DataBase::DB_NAME . ";host =" . DataBase::DB_HOST . ';',
                    DataBase::DB_USER, DataBase::DB_PASS);
                self::$instance->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            } catch (\PDOException $e){
                $e->getMessage();
            }
        }
        return self::$instance;
    }

    public static function gI()
    {
        return self::getInstance();
    }

    private function __construct(){}
    private function __clone(){
        throw new Exception("You can't clone Singleton object");
    }
}