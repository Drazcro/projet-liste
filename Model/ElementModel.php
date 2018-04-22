<?php

namespace Model;

class ElementModel extends Model
{
    /**
     * Récupère un élément par id
     * @param $id
     * @return array|bool
     */
    public function getElement($id)
    {
        try {
            $this->stmt = $this->pdo->prepare('SELECT * FROM element WHERE idelements = :id');
            $this->stmt->bindParam(':id', $id);
            $this->stmt->execute();
            return $this->stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        catch(\Exception $e) {
            return false;
        }
    }

    /**
     * Créé un élement
     * @param $date_creation
     * @param $date_modif
     * @param $titre
     * @param $description
     * @param $statut
     * @param $idListe
     * @return bool
     */
    public function createElement($date_creation, $date_modif, $titre, $description, $statut, $idListe) {
        try {
            $this->stmt = $this->pdo->prepare('INSERT INTO element (date_creation, date_modif, titre, description, statut, idListe) VALUES (:date_creation, :date_modif, :titre, :description, :statut, :idListe)');
            $this->stmt->bindParam(':date_creation', $date_creation);
            $this->stmt->bindParam(':date_modif', $date_modif);
            $this->stmt->bindParam(':titre', $titre);
            $this->stmt->bindParam(':description', $description);
            $this->stmt->bindParam(':statut', $statut);
            $this->stmt->bindParam(':idListe', $idListe);
            $this->stmt->execute();
            $this->pdo->errorInfo();
            return $this->testSuccess();
        }
        catch(\Exception $e) {
            return false;
        }
    }

    /**
     * Met à jour un élément
     * @param $date_creation
     * @param $date_modif
     * @param $titre
     * @param $description
     * @param $statut
     * @param $idListe
     * @param $idElement
     * @return bool
     */
    public function updateElement($date_creation, $date_modif, $titre, $description, $statut, $idListe, $idElement) {
        try {
            $this->stmt = $this->pdo->prepare('UPDATE element SET date_creation=:date_creation, date_modif=:date_modif, titre=:titre, description=:description, statut=:statut, idListe=:idListe  WHERE idelements = :idElement');
            $this->stmt->bindParam(':date_creation', $date_creation);
            $this->stmt->bindParam(':date_modif', $date_modif);
            $this->stmt->bindParam(':titre', $titre);
            $this->stmt->bindParam(':description', $description);
            $this->stmt->bindParam(':statut', $statut);
            $this->stmt->bindParam(':idListe', $idListe);
            $this->stmt->bindParam(':idElement', $idElement);
            $this->stmt->execute();
            return $this->testSuccess();
        }
        catch(\Exception $e) {
            return false;
        }
    }

    /**
     * Supprime un élément
     * @param $id
     * @return bool
     */
    public function deleteElement($id) {
        try {
            $this->stmt = $this->pdo->prepare('DELETE FROM element WHERE idelements=:id');
            $this->stmt->bindParam(':id', $id);
            $this->stmt->execute();
            return $this->testSuccess();
        }
        catch(\Exception $e) {
            return false;
        }
    }
}