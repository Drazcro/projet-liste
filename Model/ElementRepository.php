<?php

namespace Model;

class ElementRepository extends Repository
{
    public function getElement($id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM element WHERE idelements = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function createElement($date_creation, $date_modif, $titre, $description, $statut, $idListe) {
        try {
            $stmt = $this->pdo->prepare('INSERT INTO element (date_creation, date_modif, titre, description, statut, idListe) VALUES (:date_creation, :date_modif, :titre, :description, :statut, :idListe)');
            $stmt->bindParam(':date_creation', $date_creation);
            $stmt->bindParam(':date_modif', $date_modif);
            $stmt->bindParam(':titre', $titre);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':statut', $statut);
            $stmt->bindParam(':idListe', $idListe);
            $stmt->execute();
            $this->pdo->errorInfo();
            return true;
        }
        catch(\Exception $e) {
            return false;
        }
    }

    public function updateElement($date_creation, $date_modif, $titre, $description, $statut, $idListe, $idElement) {
        try {
            $stmt = $this->pdo->prepare('UPDATE element SET date_creation=:date_creation, date_modif=:date_modif, titre=:titre, description=:description, statut=:statut, idListe=:idListe  WHERE idelements = :idElement');
            $stmt->bindParam(':date_creation', $date_creation);
            $stmt->bindParam(':date_modif', $date_modif);
            $stmt->bindParam(':titre', $titre);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':statut', $statut);
            $stmt->bindParam(':idListe', $idListe);
            $stmt->bindParam(':idElement', $idElement);
            $stmt->execute();
            //curl -X PUT --data "table=utilisateur&function=updateUtilisateur&pseudo=penisMEGA&password=222&permission=1&role=1&idUser=1" localhost/projet-liste/main.php
            return true;
        }
        catch(\Exception $e) {
            return false;
        }
    }

    public function deleteElement($id) {
        try {
            $stmt = $this->pdo->prepare('DELETE FROM element WHERE idelements=:id');
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