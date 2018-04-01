<?php

namespace Model;

class PossederRepository extends Repository
{
    public function getEtiquette($idListe1, $idListe2)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM posseder WHERE liste_idliste = :id1 AND liste_idliste1 = :id2');
        $stmt->bindParam(':id1', $idListe1);
        $stmt->bindParam(':id2', $idListe2);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function createPosseder($idliste1, $idliste2) {
        try {
            $stmt = $this->pdo->prepare('INSERT INTO posseder (liste_idliste, liste_idliste1) VALUES (:idliste1, :idliste2)');
            $stmt->bindParam(':idliste1', $idliste1);
            $stmt->bindParam(':idliste2', $idliste2);
            $stmt->execute();
            $this->pdo->errorInfo();
            return true;
        }
        catch(\Exception $e) {
            $ec = new \Exceptions\DatabaseException($e->getCode());
            $ec->configurateDatabaseMessage();
            $ec->setResponse();
        }
    }

    public function updatePosseder($idListe1, $idListe2, $newListe1, $newListe2) {
        try {
            $stmt = $this->pdo->prepare('UPDATE posseder SET liste_idliste=:liste_idliste, liste_idliste1=:liste_idliste1 WHERE liste_idliste = :newIdListe1 AND liste_idliste1 = :newIdListe2');
            $stmt->bindParam(':liste_idliste', $idListe1);
            $stmt->bindParam(':liste_idliste1', $idListe2);
            $stmt->bindParam(':newIdListe1', $newListe1);
            $stmt->bindParam(':newIdListe2', $newListe2);
            $stmt->execute();
            return true;
        }
        catch(\Exception $e) {
            var_dump($e->getMessage());
            return false;
        }
    }

    public function deletePosseder($idListe1, $idListe2) {
        try {
            $stmt = $this->pdo->prepare('DELETE FROM posseder WHERE liste_idliste = :idListe1 AND liste_idliste1 = :idListe2');
            $stmt->bindParam(':idListe1', $idListe1);
            $stmt->bindParam(':idListe2', $idListe2);
            $stmt->execute();
            return true;
        }
        catch(\Exception $e) {
            $ec = new \Exceptions\DatabaseException($e->getCode());
            $ec->configurateDatabaseMessage();
            $ec->setResponse();
        }
    }
}