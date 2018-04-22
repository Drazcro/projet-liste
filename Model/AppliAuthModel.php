<?php

namespace Model;

class AppliAuthModel extends Model
{
    /**
     * Récupère une appli par pseudo et password
     * @param $pseudo
     * @param $password
     * @return array|bool
     */
    public function getAppByPseudoPassword($pseudo, $password) {
        try {
            $password = hash('sha512',$password);
            $this->stmt = $this->pdo->prepare('SELECT * FROM appliauth WHERE name = :pseudo AND password = :password');
            $this->stmt->bindParam(':pseudo', $pseudo);
            $this->stmt->bindParam(':password', $password);
            $this->stmt->execute();
            return  $this->stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
        catch(\Exception $e) {
            return false;
        }
    }
}