<?php

namespace Model;

class Repository
{
    protected $pdo;

    public function __construct()
    {
        $this->pdo = new \PDO('mysql:host=localhost;dbname='.DB_NAME, DB_USER, DB_PASSWORD);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
    }
}