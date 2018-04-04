<?php

namespace Model;

class EtiquetteRepository extends Repository
{
    public function getEtiquette($id)
    {
        try {
            $this->stmt = $this->pdo->prepare('SELECT * FROM etiquette WHERE idetiquette = :id');
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

    public function createEtiquette($tag, $idUser) {
        try {
            $this->stmt = $this->pdo->prepare('INSERT INTO etiquette (tag, idUser) VALUES (:tag, :idUser)');
            $this->stmt->bindParam(':tag', $tag);
            $this->stmt->bindParam(':idUser', $idUser);
            $this->stmt->execute();
            $this->pdo->errorInfo();
            return $this->testSuccess();
        }
        catch(\Exception $e) {
            /*$ec = new \Exceptions\DatabaseException($e->getCode());
            $ec->configurateDatabaseMessage();
            $ec->setResponse();*/
            return false;
        }
    }

    public function updateEtiquette($tag, $idUser, $idEtiquette) {
        try {
            $this->stmt = $this->pdo->prepare('UPDATE etiquette SET tag=:tag, idUser=:idUser WHERE idetiquette = :idEtiquette');
            $this->stmt->bindParam(':tag', $tag);
            $this->stmt->bindParam(':idUser', $idUser);
            $this->stmt->bindParam(':idEtiquette', $idEtiquette);
            $this->stmt->execute();
            //curl -X PUT --data "table=utilisateur&function=updateUtilisateur&pseudo=penisMEGA&password=222&permission=1&role=1&idUser=1" localhost/projet-liste/main.php
            return true;
        }
        catch(\Exception $e) {
            /*$ec = new \Exceptions\DatabaseException($e->getCode());
            $ec->configurateDatabaseMessage();
            $ec->setResponse();*/
            return $this->testSuccess();
        }
    }

    public function deleteEtiquette($id) {
        try {
            $this->stmt = $this->pdo->prepare('DELETE FROM etiquette WHERE idetiquette = :id');
            $this->stmt->bindParam(':id', $id);
            $this->stmt->execute();
            //curl -X DELETE --data "table=utilisateur&function=deleteUtilisateur&idUser=1" localhost/projet-liste/main.php
            return $this->testSuccess();
        }
        catch(\Exception $e) {
            /*$ec = new \Exceptions\DatabaseException($e->getCode());
            $ec->configurateDatabaseMessage();
            $ec->setResponse();*/
            return false;
        }
    }
}