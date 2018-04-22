<?php

namespace Model;

/**
 * Class ListeModel
 * @package Model
 * Gère les requêtes sur les listes.
 */
class ListeModel extends Model
{
    /**
     * Récupère une liste par id
     * @param $id
     * @return array|bool
     */
    public function getListe($id)
    {
        try {

            $this->stmt = $this->pdo->prepare('SELECT * FROM liste WHERE idliste = :id');
            $this->stmt->bindParam(':id', $id);
            $this->stmt->execute();
            return $this->stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        catch(\Exception $e) {
            return false;
        }
    }

    /**
     * Récupère toute les listes ou celles associés à un id d'utilisateur et celles ouvertes
     * @param null $idUser
     * @return array|bool
     */
    public function getAllListe($idUser=null) {
        try {
            if(isset($idUser)) {
                $this->stmt = $this->pdo->prepare('SELECT * FROM liste WHERE idUSer = :id OR visibility = 1');
                $this->stmt->bindParam(':id', $idUser);
            }
            else
                $this->stmt = $this->pdo->prepare('SELECT * FROM liste');
            $this->stmt->execute();
            return $this->stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        catch(\Exception $e) {
            return false;
        }
    }

    /**
     * Récupère toutes les listes publiques
     * @return bool
     */
    public function getPublicListe() {
        try {
            $this->stmt = $this->pdo->prepare('SELECT * FROM liste WHERE visibility = 1');
            $this->stmt->execute();
            return $this->stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        catch(\Exception $e) {
            return false;
        }
    }

    /**
     * Récupère les élements associés à une liste
     * @param $idListe
     * @return array|bool
     */
    public function getElements($idListe) {
        try {
            $this->stmt = $this->pdo->prepare('SELECT * FROM element WHERE idListe = :id ORDER BY idListe DESC');
            $this->stmt->bindParam(':id', $idListe);
            $this->stmt->execute();
            return $this->stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        catch(\Exception $e) {
            return false;
        }
    }

    /**
     * Créé une liste
     * @param $id
     * @param $description
     * @param $visibility
     * @param $title
     * @return bool
     */
    public function createListe($id, $description, $visibility, $title) {
        try {
            $this->stmt = $this->pdo->prepare('INSERT INTO liste (title, description, visibility, idUser) VALUES (:title, :description, :visibility, :idUser)');
            $this->stmt->bindParam(':title', $title);
            $this->stmt->bindParam(':description', $description);
            $this->stmt->bindParam(':visibility', $visibility);
            $this->stmt->bindParam(':idUser', $id);
            $this->stmt->execute();
            return $this->testSuccess();
        }
        catch(\Exception $e) {
            return false;
        }
    }

    /**
     * Supprime une liste
     * @param $id
     * @return bool
     */
    public function deleteListe($id) {
        try {
            $this->stmt = $this->pdo->prepare('DELETE FROM liste WHERE idListe=:id');
            $this->stmt->bindParam(':id', $id);
            $this->stmt->execute();
            return $this->testSuccess();
        }
        catch(\Exception $e) {
            return false;
        }
    }

    /**
     * Met à jour une liste
     * @param $idUser
     * @param $title
     * @param $description
     * @param $visibility
     * @param $idListe
     * @return bool
     */
    public function updateListe($idUser, $title, $description, $visibility, $idListe) {
        try {
            $this->stmt = $this->pdo->prepare('UPDATE liste SET title=:title, description=:description, visibility=:visibility, idUser=:idUser WHERE idListe = :idListe');
            $this->stmt->bindParam(':title', $title);
            $this->stmt->bindParam(':description', $description);
            $this->stmt->bindParam(':visibility', $visibility);
            $this->stmt->bindParam(':idUser', $idUser);
            $this->stmt->bindParam(':idListe', $idListe);
            $this->stmt->execute();
            return $this->testSuccess();
        }
        catch(\Exception $e) {
            $e->getMessage();
            return false;
        }
    }
}