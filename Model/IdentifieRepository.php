<?php

namespace Model;

class IdentifieRepository extends Repository
{
    public function getIdentifie($element_idElements, $etiquette_idEtiquette)
    {
        try {
            $this->stmt = $this->pdo->prepare('SELECT * FROM identifie WHERE element_idelements = :element_idElements AND etiquette_idetiquette = :etiquette_idEtiquette');
            $this->stmt->bindParam(':element_idElements', $element_idElements);
            $this->stmt->bindParam(':etiquette_idEtiquette', $etiquette_idEtiquette);
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

    public function createIdentifie($element_idElements, $etiquette_idEtiquette) {
        try {
            $this->stmt = $this->pdo->prepare('INSERT INTO identifie (element_idelements, etiquette_idetiquette) VALUES (:element_idElements, :etiquette_idEtiquette)');
            $this->stmt->bindParam(':element_idElements', $element_idElements);
            $this->stmt->bindParam(':etiquette_idEtiquette', $etiquette_idEtiquette);
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



    public function updateIdentifie($element_idElements, $etiquette_idEtiquette, $newIdElements, $newIdEtiquette) {
        try {
            $this->stmt = $this->pdo->prepare('UPDATE identifie SET element_idelements=:element_idElements, etiquette_idetiquette=:etiquette_idEtiquette WHERE element_idelements = :element_idElements2 AND etiquette_idetiquette = :etiquette_idEtiquette2');
            $this->stmt->bindParam(':element_idElements', $newIdElements);
            $this->stmt->bindParam(':etiquette_idEtiquette', $newIdEtiquette);
            $this->stmt->bindParam(':element_idElements2', $element_idElements);
            $this->stmt->bindParam(':etiquette_idEtiquette2', $etiquette_idEtiquette);
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

    public function deleteIdentifie($element_idElements, $etiquette_idEtiquette) {
        try {
            $this->stmt = $this->pdo->prepare('DELETE FROM identifie WHERE element_idelements = :element_idElements AND etiquette_idEtiquette = :etiquette_idEtiquette');
            $this->stmt->bindParam(':element_idElements', $element_idElements);
            $this->stmt->bindParam(':etiquette_idEtiquette', $etiquette_idEtiquette);
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
}