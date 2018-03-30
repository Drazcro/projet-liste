<?php

namespace Model;

class PossederRepository extends Repository
{
    public function getEtiquette($id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM etiquette WHERE idetiquette = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function createPosseder($idliste1, $idliste2) {
        try {
           // echo 'laaaaaaaaa';
            $stmt = $this->pdo->prepare('INSERT INTO posseder (liste_idliste, liste_idliste1) VALUES (:idliste1, :idliste2)');
            $stmt->bindParam(':idliste1', $idliste1);
            $stmt->bindParam(':idliste2', $idliste2);
            $stmt->execute();
            $this->pdo->errorInfo();
            return true;
        }
        catch(\Exception $e) {
            var_dump($e->getMessage());
            return false;
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
            return false;
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

            return false;
        }
    }
}