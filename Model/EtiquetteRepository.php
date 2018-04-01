<?php

namespace Model;

class EtiquetteRepository extends Repository
{
    public function getEtiquette($id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM etiquette WHERE idetiquette = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function createEtiquette($tag, $idUser) {
        try {
            $stmt = $this->pdo->prepare('INSERT INTO etiquette (tag, idUser) VALUES (:tag, :idUser)');
            $stmt->bindParam(':tag', $tag);
            $stmt->bindParam(':idUser', $idUser);
            $stmt->execute();
            $this->pdo->errorInfo();
            return true;
        }
        catch(\Exception $e) {
            $ec = new \Exceptions\DatabaseException($e->getCode());
            $ec->configurateDatabaseMessage();
            $ec->setResponse();
        }
    }

    public function updateEtiquette($tag, $idUser, $idEtiquette) {
        try {
            $stmt = $this->pdo->prepare('UPDATE etiquette SET tag=:tag, idUser=:idUser WHERE idetiquette = :idEtiquette');
            $stmt->bindParam(':tag', $tag);
            $stmt->bindParam(':idUser', $idUser);
            $stmt->bindParam(':idEtiquette', $idEtiquette);
            $stmt->execute();
            //curl -X PUT --data "table=utilisateur&function=updateUtilisateur&pseudo=penisMEGA&password=222&permission=1&role=1&idUser=1" localhost/projet-liste/main.php
            return true;
        }
        catch(\Exception $e) {
            $ec = new \Exceptions\DatabaseException($e->getCode());
            $ec->configurateDatabaseMessage();
            $ec->setResponse();
        }
    }

    public function deleteEtiquette($id) {
        try {
            $stmt = $this->pdo->prepare('DELETE FROM etiquette WHERE idetiquette = :id');
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            //curl -X DELETE --data "table=utilisateur&function=deleteUtilisateur&idUser=1" localhost/projet-liste/main.php
            return true;
        }
        catch(\Exception $e) {
            $ec = new \Exceptions\DatabaseException($e->getCode());
            $ec->configurateDatabaseMessage();
            $ec->setResponse();
        }
    }
}