<?php

namespace Model;

class PartageRepository extends Repository
{
    public function getPartage($utilisateur_idUser, $liste_idListe)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM partage WHERE utilisateur_idUser = :utilisateur_idUser AND liste_idListe = :liste_idListe');
        $stmt->bindParam(':utilisateur_idUser', $utilisateur_idUser);
        $stmt->bindParam(':liste_idListe', $liste_idListe);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function createPartage($utilisateur_idUser, $liste_idliste, $autorisation) {
        try {
            $stmt = $this->pdo->prepare('INSERT INTO partage (utilisateur_idUser, liste_idliste, autorisation) VALUES (:utilisateur_idUser, :liste_idliste, :autorisation)');
            $stmt->bindParam(':utilisateur_idUser', $utilisateur_idUser);
            $stmt->bindParam(':liste_idliste', $liste_idliste);
            $stmt->bindParam(':autorisation', $autorisation);
            $stmt->execute();
            $this->pdo->errorInfo();
            return true;
        }
        catch(\Exception $e) {
            return false;
        }
    }

    public function updatePartage($utilisateur_idUser, $liste_idliste, $autorisation) {
        try {
            $stmt = $this->pdo->prepare('UPDATE partage SET utilisateur_idUser=:utilisateur_idUser, liste_idliste=:liste_idliste, autorisation=:autorisation WHERE utilisateur_idUser = :utilisateur_idUser2 AND liste_idliste=:liste_idliste2');
            $stmt->bindParam(':utilisateur_idUser', $utilisateur_idUser);
            $stmt->bindParam(':liste_idliste', $liste_idliste);
            $stmt->bindParam(':autorisation', $autorisation);
            $stmt->bindParam(':utilisateur_idUser2', $utilisateur_idUser);
            $stmt->bindParam(':liste_idliste2', $liste_idliste);
            $stmt->execute();
            //curl -X PUT --data "table=utilisateur&function=updateUtilisateur&pseudo=penisMEGA&password=222&permission=1&role=1&idUser=1" localhost/projet-liste/main.php
            return true;
        }
        catch(\Exception $e) {
            return false;
        }
    }

    public function deletePartage($utilisateur_idUser, $liste_idliste) {
        try {
            $stmt = $this->pdo->prepare('DELETE FROM partage WHERE utilisateur_idUser = :utilisateur_idUser AND liste_idliste= :liste_idliste');
            $stmt->bindParam(':utilisateur_idUser', $utilisateur_idUser);
            $stmt->bindParam(':liste_idliste', $liste_idliste);
            $stmt->execute();
            //curl -X DELETE --data "table=utilisateur&function=deleteUtilisateur&idUser=1" localhost/projet-liste/main.php
            return true;
        }
        catch(\Exception $e) {

            return false;
        }
    }
}