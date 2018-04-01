<?php

namespace Model;

class IdentifieRepository extends Repository
{
    public function getIdentifie($element_idElements, $etiquette_idEtiquette)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM identifie WHERE element_idelements = :element_idElements AND etiquette_idetiquette= :etiquette_idEtiquette');
        $stmt->bindParam(':element_idElements', $element_idElements);
        $stmt->bindParam(':etiquette_idEtiquette', $etiquette_idEtiquette);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function createIdentifie($element_idElements, $etiquette_idEtiquette) {
        try {
            $stmt = $this->pdo->prepare('INSERT INTO identifie (element_idelements, etiquette_idetiquette) VALUES (:element_idElements, :etiquette_idEtiquette)');
            $stmt->bindParam(':element_idElements', $element_idElements);
            $stmt->bindParam(':etiquette_idEtiquette', $etiquette_idEtiquette);
            $stmt->execute();
            $this->pdo->errorInfo();
            return true;
        }
        catch(\Exception $e) {
            return false;
        }
    }



    public function updateIdentifie($element_idElements, $etiquette_idEtiquette, $newIdElements, $newIdEtiquette) {
        try {
            $stmt = $this->pdo->prepare('UPDATE identifie SET element_idelements=:element_idElements, etiquette_idetiquette=:etiquette_idEtiquette WHERE element_idelements = :element_idElements2 AND etiquette_idetiquette = :etiquette_idEtiquette2');
            $stmt->bindParam(':element_idElements', $element_idElements);
            $stmt->bindParam(':etiquette_idEtiquette', $etiquette_idEtiquette);
            $stmt->bindParam(':element_idElements2', $newIdElements);
            $stmt->bindParam(':etiquette_idEtiquette2', $newIdEtiquette);
            $stmt->execute();
            //curl -X PUT --data "table=utilisateur&function=updateUtilisateur&pseudo=penisMEGA&password=222&permission=1&role=1&idUser=1" localhost/projet-liste/main.php
            return true;
        }
        catch(\Exception $e) {
            return false;
        }
    }

    public function deleteIdentifie($element_idElements, $etiquette_idEtiquette) {
        try {
            $stmt = $this->pdo->prepare('DELETE FROM identifie WHERE element_idelements = :element_idElements AND etiquette_idEtiquette = :etiquette_idEtiquette');
            $stmt->bindParam(':element_idElements', $element_idElements);
            $stmt->bindParam(':etiquette_idEtiquette', $etiquette_idEtiquette);
            $stmt->execute();
            //curl -X DELETE --data "table=utilisateur&function=deleteUtilisateur&idUser=1" localhost/projet-liste/main.php
            return true;
        }
        catch(\Exception $e) {
            var_dump($e->getMessage());
            return false;
        }
    }
}