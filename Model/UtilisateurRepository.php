<?php

namespace Model;

class UtilisateurRepository extends Repository
{
    public function getUtilisateur($param)
    {
        try {
            if(is_numeric($param))
                $stmt = $this->pdo->prepare('SELECT * FROM utilisateur WHERE idUser = :param');
            else
                $stmt = $this->pdo->prepare('SELECT * FROM utilisateur WHERE pseudo = :param');
            $stmt->bindParam(':param', $param);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        catch(\Exception $e) {
            /*$ec = new \Exceptions\DatabaseException($e->getCode());
            $ec->configurateDatabaseMessage();
            $ec->setResponse();*/
            return false;
        }
    }

    public function getAllUtilisateur()
    {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM utilisateur');
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        catch(\Exception $e) {
            /*$ec = new \Exceptions\DatabaseException($e->getCode());
            $ec->configurateDatabaseMessage();
            $ec->setResponse();*/
            return false;
        }
    }

    public function getUtilisateurByPseudoPassword($pseudo, $password) {
        try {
            $password = hash('sha512',$password);
            $stmt = $this->pdo->prepare('SELECT * FROM utilisateur WHERE pseudo = :pseudo AND password = :password');
            $stmt->bindParam(':pseudo', $pseudo);
            $stmt->bindParam(':password', $password);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        catch(\Exception $e) {
           /* $ec = new \Exceptions\DatabaseException($e->getCode());
            $ec->configurateDatabaseMessage();
            $ec->setResponse();*/
            return false;
        }
    }

    public function createUtilisateur($pseudo, $password, $permission, $role) {
        try {
            $password = hash('sha512',$password);
            $stmt = $this->pdo->prepare('INSERT INTO utilisateur (pseudo, password, permission, role) VALUES (:pseudo, :password, :permission, :role)');
            $stmt->bindValue(':pseudo', $pseudo);
            $stmt->bindValue(':password', $password);
            $stmt->bindValue(':permission', $permission);
            $stmt->bindValue(':role', $role);
            $stmt->execute();
            return true;
        }
        catch(\Exception $e) {
            /*$ec = new \Exceptions\DatabaseException($e->getCode());
            $ec->configurateDatabaseMessage();
            $ec->setResponse();*/
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
            return true;
        }
        catch(\Exception $e) {
            /*$ec = new \Exceptions\DatabaseException($e->getCode());
            $ec->configurateDatabaseMessage();
            $ec->setResponse();*/
            return false;
        }
    }

    public function deleteUtilisateur($id) {
        try {
            $stmt = $this->pdo->prepare('DELETE FROM utilisateur WHERE idUser=:id');
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return true;
        }
        catch(\Exception $e) {
            /*$ec = new \Exceptions\DatabaseException($e->getCode());
            $ec->configurateDatabaseMessage();
            $ec->setResponse();*/
            return false;
        }
    }
}