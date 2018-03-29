<?php

namespace Model;

class UtilisateurRepository extends Repository
{
    public function getUtilisateur($id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM utilisateur WHERE idUser = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function createUtilisateur($pseudo, $password, $permission, $role) {
        try {
            $password = hash('sha512',$password);
            $stmt = $this->pdo->prepare('INSERT INTO utilisateur (pseudo, password, permission, role) VALUES (:pseudo, :password, :permission, :role)');
            $stmt->bindParam(':pseudo', $pseudo);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':permission', $permission);
            $stmt->bindParam(':role', $role);
            $stmt->execute();
            $this->pdo->errorInfo();
            //curl -X POST --data "table=utilisateur&function=createUtilisateur&pseudo=penis&password=222&permission=1&role=1" localhost/projet-liste/main.php
            return true;
        }
        catch(\Exception $e) {
            return false;
        }
    }

    public function updateUtilisateur($pseudo, $password, $permission, $role, $idUser) {
        try {
            $password = hash('sha512',$password);
            $stmt = $this->pdo->prepare('UPDATE utilisateur SET pseudo=:pseudo, password=:password, permission=:permission, role=:role WHERE idUser = :idUser');
            $stmt->bindParam(':pseudo', $pseudo);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':permission', $permission);
            $stmt->bindParam(':role', $role);
            $stmt->bindParam(':idUser', $idUser);
            $stmt->execute();
            //curl -X PUT --data "table=utilisateur&function=updateUtilisateur&pseudo=penisMEGA&password=222&permission=1&role=1&idUser=1" localhost/projet-liste/main.php
            return true;
        }
        catch(\Exception $e) {
            return false;
        }
    }

    public function deleteUtilisateur($id) {
        try {
            $stmt = $this->pdo->prepare('DELETE FROM utilisateur WHERE idUser=:id');
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