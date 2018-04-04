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
            $stmt = $this->pdo->prepare('SELECT * FROM liste WHERE idliste = :id');
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        catch(\Exception $e) {
           /*$ec = new \Exceptions\DatabaseException($e->getCode());
           $ec->configurateDatabaseMessage();
           $ec->setResponse();*/
            return false;
        }
    }

    public function getAllListe($idUser=null) {
        try {
            if(isset($idUser)) {
                $stmt = $this->pdo->prepare('SELECT * FROM liste WHERE idUSer = :id OR visibility = 1');
                $stmt->bindParam(':id', $idUser);
            }
            else
                $stmt = $this->pdo->prepare('SELECT * FROM liste');

            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        catch(\Exception $e) {
            /*$ec = new \Exceptions\DatabaseException($e->getCode());
            $ec->configurateDatabaseMessage();
            $ec->setResponse();*/
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
            return true;
        }
        catch(\Exception $e) {
            /**$ec = new \Exceptions\DatabaseException($e->getCode());
            $ec->configurateDatabaseMessage();
            $ec->setResponse();*/
            return false;
        }
    }

    public function deleteListe($id) {
        try {
            $stmt = $this->pdo->prepare('DELETE FROM liste WHERE idListe=:id');
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return true;
        }
        catch(\Exception $e) {
            /*$ec = new \Exceptions\DatabaseException($e->getCode());
            $ec->configurateDatabaseMessage();
            $ec->setResponse();*/
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
            return true;
        }
        catch(\Exception $e) {
            /*$ec = new \Exceptions\DatabaseException($e->getCode());
            $ec->configurateDatabaseMessage();
            $ec->setResponse();*/
            return false;
        }
    }
}