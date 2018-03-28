<?php

namespace Model;

class Repository
{
    protected $pdo;

    public function __construct()
    {
        $this->pdo = new \PDO('mysql:host=localhost;dbname='.DB_NAME, DB_USER, DB_PASSWORD);
    }
}