<?php

namespace Model;

class UtilisateurModel extends Model
{
    /**
     * Récupère un utilisateur par id ou pseudo
     * @param $param
     * @return array|bool
     */
    public function getUtilisateur($param)
    {
        try {
            if(is_numeric($param))
                $this->stmt = $this->pdo->prepare('SELECT * FROM utilisateur WHERE idUser = :param');
            else
                $this->stmt = $this->pdo->prepare('SELECT * FROM utilisateur WHERE pseudo = :param');
            $this->stmt->bindParam(':param', $param);
            $this->stmt->execute();
            return  $this->stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        catch(\Exception $e) {
            return false;
        }
    }

    /**
     * Récupère tout les utilisateurs
     * @return array|bool
     */
    public function getAllUtilisateur()
    {
        try {
            $this->stmt = $this->pdo->prepare('SELECT * FROM utilisateur');
            $this->stmt->execute();
            return  $this->stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        catch(\Exception $e) {
            return false;
        }
    }

    /**
     * Récupère un utilisateur par pseudo et password
     * @param $pseudo
     * @param $password
     * @return array|bool
     */
    public function getUtilisateurByPseudoPassword($pseudo, $password) {
        try {
            $password = hash('sha512',$password);
            $this->stmt = $this->pdo->prepare('SELECT * FROM utilisateur WHERE pseudo = :pseudo AND password = :password');
            $this->stmt->bindParam(':pseudo', $pseudo);
            $this->stmt->bindParam(':password', $password);
            $this->stmt->execute();
            return  $this->stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        catch(\Exception $e) {
            return false;
        }
    }

    /**
     * Créé un utilisateur
     * @param $pseudo
     * @param $password
     * @param $permission
     * @param $role
     * @return bool
     */
    public function createUtilisateur($pseudo, $password, $permission, $role) {
        try {
            $password = hash('sha512',$password);
            $this->stmt = $this->pdo->prepare('INSERT INTO utilisateur (pseudo, password, permission, role) VALUES (:pseudo, :password, :permission, :role)');
            $this->stmt->bindValue(':pseudo', $pseudo);
            $this->stmt->bindValue(':password', $password);
            $this->stmt->bindValue(':permission', $permission);
            $this->stmt->bindValue(':role', $role);
            $this->stmt->execute();
            return $this->testSuccess();
        }
        catch(\Exception $e) {
            return false;
        }
    }

    /**
     * Met à jour un utilisateur
     * @param $pseudo
     * @param $password
     * @param $permission
     * @param $role
     * @param $idUser
     * @return bool
     */
    public function updateUtilisateur($pseudo, $password, $permission, $role, $idUser) {
        try {
            $password = hash('sha512',$password);
            $this->stmt = $this->pdo->prepare('UPDATE utilisateur SET pseudo=:pseudo, password=:password, permission=:permission, role=:role WHERE idUser = :idUser');
            $this->stmt->bindParam(':pseudo', $pseudo);
            $this->stmt->bindParam(':password', $password);
            $this->stmt->bindParam(':permission', $permission);
            $this->stmt->bindParam(':role', $role);
            $this->stmt->bindParam(':idUser', $idUser);
            $this->stmt->execute();
            return $this->testSuccess();
        }
        catch(\Exception $e) {
            return false;
        }
    }

    /**
     * Supprime un utilisateur
     * @param $id
     * @return bool
     */
    public function deleteUtilisateur($id) {
        try {
            $this->stmt = $this->pdo->prepare('DELETE FROM utilisateur WHERE idUser=:id');
            $this->stmt->bindParam(':id', $id);
            $this->stmt->execute();
            return $this->testSuccess();
        }
        catch(\Exception $e) {
            return false;
        }
    }
}