<?php

namespace Model;

class ListeRepository extends Repository
{

    public function get(...$p)
    {
        $stmt = $this->pdo->prepare('SELECT title,description FROM liste WHERE idUser = '.$p[0]. ' OR visibility = 1 OR idListe IN (SELECT liste_idliste FROM partage WHERE utilisateur_idUser = '.$p[0].')');
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
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