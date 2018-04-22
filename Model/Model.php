<?php

namespace Model;

class Model
{
    protected $pdo;
    protected $stmt;

    public function __construct()
    {
        $this->pdo = new \PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASSWORD);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
        $this->pdo->setAttribute(\PDO::MYSQL_ATTR_FOUND_ROWS, true);
        $this->stmt = null;
    }

    /**
     * Teste le succès d'une mise à jour / insertion / suppression -> au moins 1 ligne affectée
     * @return bool
     */
    protected function testSuccess() {
        if($this->stmt->rowCount() > 0)
            return true;
        return false;
    }
}