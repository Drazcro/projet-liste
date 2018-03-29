<?php

namespace Model;

/**
 * Class ListeRepository
 * @package Model
 * Gère les requêtes sur les listes.
 */
class ListeRepository extends Repository
{

    public function get(...$p)
    {
        $id = $p[0];
        $stmt = $this->pdo->prepare('SELECT title,description FROM liste WHERE idUser = '.$id. ' OR visibility = 1 OR idListe IN (SELECT liste_idliste FROM partage WHERE utilisateur_idUser = '.$id.')');
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getList($id)
    {
        $stmt = $this->pdo->prepare('SELECT title,description FROM liste WHERE idUser = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function createList($id, $description, $visibility, $title) {
        try {
            $stmt = $this->pdo->prepare('INSERT INTO liste (title, description, visibility, idUser) VALUES (:title, :description, :visibility, :idUser)');
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':visibility', $visibility);
            $stmt->bindParam(':idUser', $id);
            $stmt->execute();
            //curl -X POST --data "table=liste&function=createListe&description=penis&title=superpenis&idUser=1&visibility=1" localhost/projet-liste/main.php
            return true;
        }
        catch(\Exception $e) {
            return false;
        }
    }

    public function deleteList($id) {
        try {
            $stmt = $this->pdo->prepare('DELETE FROM liste WHERE idListe=:id');
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            //curl -X DELETE --data "table=liste&function=deleteListe&idListe=1" localhost/projet-liste/main.php
            return true;
        }
        catch(\Exception $e) {
            return false;
        }
    }

    public function updateListe($idUser, $title, $description, $visibility, $idListe) {
        try {
            $stmt = $this->pdo->prepare('UPDATE liste SET title=:title, description=:description, visibility=:visibility, idUser=:idUser WHERE idListe = :idListe');
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':visibility', $visibility);
            $stmt->bindParam(':idUser', $idUser);
            $stmt->bindParam(':idListe', $idListe);
            $stmt->execute();
            //curl -X PUT --data "table=liste&function=updateListe&description=penis&title=superpenis&idUser=1&visibility=1&idListe=1" localhost/projet-liste/main.php
            return true;
            }
        catch(\Exception $e) {
        return false;
}
    }
}