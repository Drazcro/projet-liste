<?php

namespace Model;

class ListeRepository extends Repository
{

    public function get(...$p)
    {
        $id = $p[0];
        $stmt = $this->pdo->prepare('SELECT title,description FROM liste WHERE idUser = '.$id. ' OR visibility = 1 OR idListe IN (SELECT liste_idliste FROM partage WHERE utilisateur_idUser = '.$id.')');
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