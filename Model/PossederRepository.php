<?php

namespace Model;

class PossederRepository extends Repository
{
    /**
     * Récupère une possession
     * @param $idListe1
     * @param $idListe2
     * @return array|bool
     */
    public function getPosseder($idListe1, $idListe2)
    {
        try {
            $this->stmt = $this->pdo->prepare('SELECT * FROM posseder WHERE liste_idliste = :id1 AND liste_idliste1 = :id2');
            $this->stmt->bindParam(':id1', $idListe1);
            $this->stmt->bindParam(':id2', $idListe2);
            $this->stmt->execute();
            return  $this->stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        catch(\Exception $e) {
            return false;
        }
    }

    /**
     * Créé une possession
     * @param $idliste1
     * @param $idliste2
     * @return bool
     */
    public function createPosseder($idliste1, $idliste2) {
        try {
            $this->stmt = $this->pdo->prepare('INSERT INTO posseder (liste_idliste, liste_idliste1) VALUES (:idliste1, :idliste2)');
            $this->stmt->bindParam(':idliste1', $idliste1);
            $this->stmt->bindParam(':idliste2', $idliste2);
            $this->stmt->execute();
            return  $this->testSuccess();
        }
        catch(\Exception $e) {
            return false;
        }
    }

    /**
     * Met à jour une possession
     * @param $idListe1
     * @param $idListe2
     * @param $newListe1
     * @param $newListe2
     * @return bool
     */
    public function updatePosseder($idListe1, $idListe2, $newListe1, $newListe2) {
        try {
            $this->stmt = $this->pdo->prepare('UPDATE posseder SET liste_idliste=:liste_idliste, liste_idliste1=:liste_idliste1 WHERE liste_idliste = :newIdListe1 AND liste_idliste1 = :newIdListe2');
            $this->stmt->bindParam(':liste_idliste', $newListe1);
            $this->stmt->bindParam(':liste_idliste1', $newListe2);
            $this->stmt->bindParam(':newIdListe1', $idListe1);
            $this->stmt->bindParam(':newIdListe2', $idListe2);
            $this->stmt->execute();
            return $this->testSuccess();
        }
        catch(\Exception $e) {
            return false;
        }
    }

    /**
     * Supprime une possession
     * @param $idListe1
     * @param $idListe2
     * @return bool
     */
    public function deletePosseder($idListe1, $idListe2) {
        try {
            $this->stmt = $this->pdo->prepare('DELETE FROM posseder WHERE liste_idliste = :idListe1 AND liste_idliste1 = :idListe2');
            $this->stmt->bindParam(':idListe1', $idListe1);
            $this->stmt->bindParam(':idListe2', $idListe2);
            $this->stmt->execute();
            return  $this->testSuccess();
        }
        catch(\Exception $e) {
            return false;
        }
    }
}