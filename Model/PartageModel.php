<?php

namespace Model;

class PartageModel extends Model
{
    /**
     * Récupère un partage
     * @param $utilisateur_idUser
     * @param $liste_idListe
     * @return array|bool
     */
    public function getPartage($utilisateur_idUser, $liste_idListe)
    {
        try {
            $this->stmt = $this->pdo->prepare('SELECT * FROM partage WHERE utilisateur_idUser = :utilisateur_idUser AND liste_idListe = :liste_idListe');
            $this->stmt->bindParam(':utilisateur_idUser', $utilisateur_idUser);
            $this->stmt->bindParam(':liste_idListe', $liste_idListe);
            $this->stmt->execute();
            return  $this->stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        catch(\Exception $e) {
            return false;
        }
    }

    /**
     * Créé un partage
     * @param $utilisateur_idUser
     * @param $liste_idliste
     * @param $autorisation
     * @return bool
     */
    public function createPartage($utilisateur_idUser, $liste_idliste, $autorisation) {
        try {
            $this->stmt = $this->pdo->prepare('INSERT INTO partage (utilisateur_idUser, liste_idliste, autorisation) VALUES (:utilisateur_idUser, :liste_idliste, :autorisation)');
            $this->stmt->bindParam(':utilisateur_idUser', $utilisateur_idUser);
            $this->stmt->bindParam(':liste_idliste', $liste_idliste);
            $this->stmt->bindParam(':autorisation', $autorisation);
            $this->stmt->execute();
            return $this->testSuccess();
        }
        catch(\Exception $e) {
            return false;
        }
    }

    /**
     * Met à jour un partage
     * @param $utilisateur_idUser
     * @param $liste_idliste
     * @param $autorisation
     * @param $newIdUser
     * @param $newIdListe
     * @return bool
     */
    public function updatePartage($utilisateur_idUser, $liste_idliste, $autorisation, $newIdUser, $newIdListe) {
        try {
            $this->stmt = $this->pdo->prepare('UPDATE partage SET utilisateur_idUser=:utilisateur_idUser, liste_idliste=:liste_idliste, autorisation=:autorisation WHERE utilisateur_idUser = :utilisateur_idUser2 AND liste_idliste=:liste_idliste2');
            $this->stmt->bindParam(':utilisateur_idUser', $utilisateur_idUser);
            $this->stmt->bindParam(':liste_idliste', $liste_idliste);
            $this->stmt->bindParam(':autorisation', $autorisation);
            $this->stmt->bindParam(':utilisateur_idUser2', $newIdUser);
            $this->stmt->bindParam(':liste_idliste2', $newIdListe);
            $this->stmt->execute();
            return $this->testSuccess();
        }
        catch(\Exception $e) {
            return false;
        }
    }

    /**
     * Supprime un partage
     * @param $utilisateur_idUser
     * @param $liste_idliste
     * @return bool
     */
    public function deletePartage($utilisateur_idUser, $liste_idliste) {
        try {
            $this->stmt = $this->pdo->prepare('DELETE FROM partage WHERE utilisateur_idUser = :utilisateur_idUser AND liste_idliste= :liste_idliste');
            $this->stmt->bindParam(':utilisateur_idUser', $utilisateur_idUser);
            $this->stmt->bindParam(':liste_idliste', $liste_idliste);
            $this->stmt->execute();
            return $this->testSuccess();
        }
        catch(\Exception $e) {
            return false;
        }
    }
}