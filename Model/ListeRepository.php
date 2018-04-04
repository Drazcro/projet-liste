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

            $this->stmt = $this->pdo->prepare('SELECT * FROM liste WHERE idliste = :id');
            $this->stmt->bindParam(':id', $id);
            $this->stmt->execute();
            return $this->stmt->fetchAll(\PDO::FETCH_ASSOC);
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
                $this->stmt = $this->pdo->prepare('SELECT * FROM liste WHERE idUSer = :id OR visibility = 1');
                $this->stmt->bindParam(':id', $idUser);
            }
            else
                $this->stmt = $this->pdo->prepare('SELECT * FROM liste');
            $this->stmt->execute();
            return $this->stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        catch(\Exception $e) {
            /*$ec = new \Exceptions\DatabaseException($e->getCode());
            $ec->configurateDatabaseMessage();
            $ec->setResponse();*/
            return false;
        }
    }

    public function getElements($idListe) {
        try {
            $this->stmt = $this->pdo->prepare('SELECT * FROM element WHERE idListe = :id');
            $this->stmt->bindParam(':id', $idListe);
            $this->stmt->execute();
            return $this->stmt->fetchAll(\PDO::FETCH_ASSOC);
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
            $this->stmt = $this->pdo->prepare('INSERT INTO liste (title, description, visibility, idUser) VALUES (:title, :description, :visibility, :idUser)');
            $this->stmt->bindParam(':title', $title);
            $this->stmt->bindParam(':description', $description);
            $this->stmt->bindParam(':visibility', $visibility);
            $this->stmt->bindParam(':idUser', $id);
            $this->stmt->execute();
            return $this->testSuccess();
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
            $this->stmt = $this->pdo->prepare('DELETE FROM liste WHERE idListe=:id');
            $this->stmt->bindParam(':id', $id);
            $this->stmt->execute();
            return $this->testSuccess();
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
            $this->stmt = $this->pdo->prepare('UPDATE liste SET title=:title, description=:description, visibility=:visibility, idUser=:idUser WHERE idListe = :idListe');
            $this->stmt->bindParam(':title', $title);
            $this->stmt->bindParam(':description', $description);
            $this->stmt->bindParam(':visibility', $visibility);
            $this->stmt->bindParam(':idUser', $idUser);
            $this->stmt->bindParam(':idListe', $idListe);
            $this->stmt->execute();
            return $this->testSuccess();
        }
        catch(\Exception $e) {
            $e->getMessage();
            /*$ec = new \Exceptions\DatabaseException($e->getCode());
            $ec->configurateDatabaseMessage();
            $ec->setResponse();*/
            return false;
        }
    }
}