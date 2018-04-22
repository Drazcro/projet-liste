<?php

namespace Model;

class EtiquetteModel extends Model
{
    /**
     * Récupère une étiquette par id
     * @param $id
     * @return array|bool
     */
    public function getEtiquette($id)
    {
        try {
            $this->stmt = $this->pdo->prepare('SELECT * FROM etiquette WHERE idetiquette = :id');
            $this->stmt->bindParam(':id', $id);
            $this->stmt->execute();
            return $this->stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        catch(\Exception $e) {
            return false;
        }
    }

    /**
     * Créé une étiquette
     * @param $tag
     * @param $idUser
     * @return bool
     */
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
            return false;
        }
    }

    /**
     * Met à jour une étiquette
     * @param $tag
     * @param $idUser
     * @param $idEtiquette
     * @return bool
     */
    public function updateEtiquette($tag, $idUser, $idEtiquette) {
        try {
            $this->stmt = $this->pdo->prepare('UPDATE etiquette SET tag=:tag, idUser=:idUser WHERE idetiquette = :idEtiquette');
            $this->stmt->bindParam(':tag', $tag);
            $this->stmt->bindParam(':idUser', $idUser);
            $this->stmt->bindParam(':idEtiquette', $idEtiquette);
            $this->stmt->execute();
            return true;
        }
        catch(\Exception $e) {
            return $this->testSuccess();
        }
    }

    /**
     * Supprime une étiquette
     * @param $id
     * @return bool
     */
    public function deleteEtiquette($id) {
        try {
            $this->stmt = $this->pdo->prepare('DELETE FROM etiquette WHERE idetiquette = :id');
            $this->stmt->bindParam(':id', $id);
            $this->stmt->execute();
            return $this->testSuccess();
        }
        catch(\Exception $e) {
            return false;
        }
    }
}