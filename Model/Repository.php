<?php

namespace Model;

class Repository implements RepositoryInterface
{
    protected $pdo;

    public function __construct()
    {
        $this->pdo = new \PDO('mysql:host=localhost;dbname='.DB_NAME, DB_USER, DB_PASSWORD);
    }

    public function get(...$p)
    {
        // TODO: Implement get() method.
    }

    public function post(...$p)
    {
        // TODO: Implement post() method.
    }

    public function delete(...$p)
    {
        // TODO: Implement delete() method.
    }

    public function put(...$p)
    {
        // TODO: Implement put() method.
    }
}