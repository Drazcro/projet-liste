<?php

namespace Model;

/**
 * Class ListeRepository
 * @package Model
 * Gère les requêtes sur les listes.
 */
class ListeRepository extends Repository
{
    public function getListe($id)
    {
        try {
            $stmt = $this->pdo->prepare('SELECT title,description FROM liste WHERE idUser = :id');
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }
            //curl -X GET localhost/projet-liste/main.php/liste/1
        catch(\Exception $e) {
            return false;
        }
    }

    public function createListe($id, $description, $visibility, $title) {
        try {
            $stmt = $this->pdo->prepare('INSERT INTO liste (title, description, visibility, idUser) VALUES (:title, :description, :visibility, :idUser)');
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':visibility', $visibility);
            $stmt->bindParam(':idUser', $id);
            $stmt->execute();
            //curl -X POST --data "description=penis&title=superpenis&idUser=2&visibility=1" localhost/projet-liste/main.php/liste
            return true;
        }
        catch(\Exception $e) {
            return false;
        }
    }

    public function deleteListe($id) {
        try {
            $stmt = $this->pdo->prepare('DELETE FROM liste WHERE idListe=:id');
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            //curl -X DELETE localhost/projet-liste/main.php/liste/184
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
            //curl -X PUT --data "description=penis&title=superpenis&idUser=1&visibility=1" localhost/projet-liste/main.php/liste/185
            return true;
            }
        catch(\Exception $e) {
            return false;
        }
    }
}