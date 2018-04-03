<?php

namespace Test;

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '/../params.php');

class ApiTest extends TestCase
{
    private $idUser;
    private $idListe;
    private $idElement;
    private $idEtiquette;
    private $pdo;

    public function __construct()
    {
        parent::__construct();
        $this->pdo = new \PDO('mysql:host=localhost;dbname=' . DB_NAME, DB_USER, DB_PASSWORD);
    }

    //Fonctions utiles

    private function setIdUser()
    {
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
        $stmt = $this->pdo->prepare('SELECT * FROM utilisateur WHERE pseudo = "cedric"');
        $stmt->execute();
        $d = $stmt->fetch(\PDO::FETCH_ASSOC);
        $this->idUser = $d['idUser'];
    }

    private function setIdListe()
    {
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
        $stmt = $this->pdo->prepare('SELECT * FROM liste WHERE idUser = ' . $this->idUser);
        $stmt->execute();
        $d = $stmt->fetch(\PDO::FETCH_ASSOC);
        $this->idListe = $d['idliste'];
    }

    private function setIdElement()
    {
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
        $stmt = $this->pdo->prepare('SELECT * FROM element WHERE idListe = ' . $this->idListe);
        $stmt->execute();
        $d = $stmt->fetch(\PDO::FETCH_ASSOC);
        $this->idElement = $d['idelements'];
    }

    private function setIdEtiquette()
    {
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
        $stmt = $this->pdo->prepare('SELECT * FROM etiquette WHERE idUser = ' . $this->idUser);
        $stmt->execute();
        $d = $stmt->fetch(\PDO::FETCH_ASSOC);
        $this->idEtiquette = $d['idetiquette'];
    }

    //Tests création entités
    public function testCreateUtilisateur()
    {
        $ch = curl_init();
        $post = ['pseudo' => 'cedric', 'password' => '1234', 'permission' => 1, 'role' => 1];
        $url = URL_test."/utilisateurs";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        $res = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($res);
        $this->assertEquals(true, $res->status);
    }

    public function testCreateListe()
    {
        $this->setIdUser();
        $ch = curl_init();
        $post = ['title' => 'ma liste', 'description' => 'une description', 'visibility' => 1, 'idUser' => $this->idUser];
        $url = URL_test."/listes";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        $res = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($res);
        $this->assertEquals(true, $res->status);
    }

    public function testCreateElement()
    {
        $this->setIdUser();
        $this->setIdListe();
        $dateCrea = new \DateTime();
        $dateModif = new \DateTime();
        $ch = curl_init();
        $post = ['date_creation' => date_format($dateCrea, 'Y-m-d H:i:s'), 'date_modif' => date_format($dateModif, 'Y-m-d H:i:s'), 'titre' => 'un element', 'description' => 'un super element', 'statut' => 1, 'idListe' => $this->idListe];
        $url = URL_test."/elements";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        $res = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($res);
        $this->assertEquals(true, $res->status);
    }

    public function testCreateEtiquette()
    {
        $this->setIdUser();
        $ch = curl_init();
        $post = ['tag' => 'mon tag', 'idUser' => $this->idUser];
        $url = URL_test."/etiquettes";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        $res = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($res);
        $this->assertEquals(true, $res->status);
    }

    public function testCreateIdentifie()
    {
        $this->setIdUser();
        $this->setIdListe();
        $this->setIdEtiquette();
        $this->setIdElement();
        $ch = curl_init();
        $post = ['element_idElements' => $this->idElement, 'etiquette_idEtiquette' => $this->idEtiquette];
        $url = URL_test."/identifies";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        $res = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($res);
        $this->assertEquals(true, $res->status);
    }

    public function testCreatePartage()
    {
        $this->setIdUser();
        $this->setIdListe();
        $ch = curl_init();
        $post = ['utilisateur_idUser' => $this->idUser, 'liste_idliste' => $this->idListe, 'autorisation' => 1];
        $url = URL_test."/partages";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        $res = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($res);
        $this->assertEquals(true, $res->status);
    }

    public function testCreatePosseder()
    {
        $this->setIdUser();
        $this->setIdListe();
        $ch = curl_init();
        $post = ['idListe1' => $this->idListe, 'idListe2' => $this->idListe];
        $url = URL_test."/posseders";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        $res = json_decode(curl_exec($ch), true);
        curl_close($ch);
        $this->assertEquals(true, $res['status']);
    }

    //Tests récupération d'une entité
    public function testGetUtilisateur()
    {
        $this->setIdUser();
        $ch = curl_init();
        $url = URL_test."/utilisateurs/$this->idUser";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($res);
        $this->assertEquals(true, $res->status);
    }

    public function testGetListe()
    {
        $this->setIdUser();
        $this->setIdListe();
        $ch = curl_init();
        $url = URL_test."/listes/$this->idListe";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($res);
        $this->assertEquals(true, $res->status);
    }

    public function testGetElement()
    {
        $this->setIdUser();
        $this->setIdListe();
        $this->setIdElement();
        $ch = curl_init();
        $url = URL_test."/elements/$this->idElement";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($res);
        $this->assertEquals(true, $res->status);
    }

    public function testGetEtiquette()
    {
        $this->setIdUser();
        $this->setIdEtiquette();
        $ch = curl_init();
        $url = URL_test."/etiquettes/$this->idEtiquette";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($res);
        $this->assertEquals(true, $res->status);
    }

    public function testGetIdentifie()
    {
        $this->setIdUser();
        $this->setIdListe();
        $this->setIdElement();
        $this->setIdEtiquette();
        $ch = curl_init();
        $url = URL_test."/identifies/$this->idElement/$this->idEtiquette";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($res);
        $this->assertEquals(true, $res->status);
    }

    public function testGetPartage()
    {
        $this->setIdUser();
        $this->setIdListe();
        $ch = curl_init();
        $url = URL_test."/partages/$this->idUser/$this->idListe";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($res);
        $this->assertEquals(true, $res->status);
    }

    public function testGetPosseder()
    {
        $this->setIdUser();
        $this->setIdListe();
        $ch = curl_init();
        $url = URL_test."/posseders/$this->idListe/$this->idListe";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($res);
        $this->assertEquals(true, $res->status);
    }

    //Tests mise à jour entités
    public function testUpdateUtilisateur()
    {
        $this->setIdUser();
        $ch = curl_init();
        $post = ['pseudo' => 'cedric', 'password' => '12534', 'permission' => 1, 'role' => 1];
        $url = URL_test."/utilisateurs/$this->idUser";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
        $res = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($res);
        $this->assertEquals(true, $res->status);
    }

    public function testUpdateListe()
    {
        $this->setIdUser();
        $this->setIdListe();
        $ch = curl_init();
        $post = ['idUser' => $this->idUser, 'title' => 'ma liste 2', 'description' => 'une description 2', 'visibility' => 1];
        $url = URL_test."/listes/$this->idListe";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
        $res = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($res);
        $this->assertEquals(true, $res->status);
    }

    public function testUpdateElement()
    {
        $this->setIdUser();
        $this->setIdListe();
        $this->setIdElement();
        $ch = curl_init();
        $dateCrea = new \DateTime();
        $dateModif = new \DateTime();
        $post = ['date_creation' => date_format($dateCrea, 'Y-m-d H:i:s'), 'date_modif' => date_format($dateModif, 'Y-m-d H:i:s'), 'titre' => "nouveau titre", 'description' => 'une nouvelle description', 'statut' => 1, 'idListe' => $this->idListe];
        $url = URL_test."/elements/$this->idElement";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
        $res = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($res);
        $this->assertEquals(true, $res->status);
    }

    public function testUpdateEtiquette()
    {
        $this->setIdUser();
        $this->setIdEtiquette();
        $ch = curl_init();
        $post = ['idUser' => $this->idUser, 'tag' => 'new tag', 'idEtiquette' => $this->idEtiquette];
        $url = URL_test."/etiquettes/{id}";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
        $res = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($res);
        $this->assertEquals(true, $res->status);
    }

    public function testUpdateIdentifie()
    {
        $this->setIdUser();
        $this->setIdListe();
        $this->setIdElement();
        $this->setIdEtiquette();
        $ch = curl_init();
        $post = ['newIdElements' => $this->idElement, 'newIdEtiquette' => $this->idEtiquette];
        $url = URL_test."/identifies/$this->idElement/$this->idEtiquette";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
        $res = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($res);
        $this->assertEquals(true, $res->status);
    }

    public function testUpdatePartage()
    {
        $this->setIdUser();
        $this->setIdListe();
        $ch = curl_init();
        $post = ['newIdUser' => $this->idUser, 'newIdListe' => $this->idListe, 'autorisation' => 0];
        $url = URL_test."/partages/$this->idUser/$this->idListe";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
        $res = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($res);
        $this->assertEquals(true, $res->status);
    }

    public function testUpdatePosseder()
    {
        $this->setIdUser();
        $this->setIdListe();
        $ch = curl_init();
        $post = ['newIdListe1' => $this->idUser, 'newIdListe2' => $this->idListe];
        $url = URL_test."/posseders/$this->idListe/$this->idListe";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
        $res = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($res);
        $this->assertEquals(true, $res->status);
    }

    //Tests suppression entité
    public function testDeletePosseder()
    {
        $this->setIdUser();
        $this->setIdListe();
        $ch = curl_init();
        $url = URL_test."/posseders/$this->idListe/$this->idListe";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($res);
        $this->assertEquals(true, $res->status);
    }

    public function testDeletePartage()
    {
        $this->setIdUser();
        $this->setIdListe();
        $ch = curl_init();
        $url = URL_test."/partages/$this->idUser/$this->idListe";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($res);
        $this->assertEquals(true, $res->status);
    }

    public function testDeleteIdentifie()
    {
        $this->setIdUser();
        $this->setIdListe();
        $this->setIdElement();
        $this->setIdEtiquette();
        $ch = curl_init();
        $url = URL_test."/identifies/$this->idElement/$this->idEtiquette";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($res);
        $this->assertEquals(true, $res->status);
    }

    public function testDeleteEtiquette()
    {
        $this->setIdUser();
        $this->setIdEtiquette();
        $ch = curl_init();
        $url = URL_test."/etiquettes/$this->idEtiquette";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($res);
        $this->assertEquals(true, $res->status);
    }

    public function testDeleteElement()
    {
        $this->setIdUser();
        $this->setIdListe();
        $this->setIdElement();
        $ch = curl_init();
        $url = URL_test."/elements/$this->idElement";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($res);
        $this->assertEquals(true, $res->status);
    }

    public function testDeleteListe()
    {
        $this->setIdUser();
        $this->setIdListe();
        $ch = curl_init();
        $url = URL_test."/listes/$this->idListe";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($res);
        $this->assertEquals(true, $res->status);
    }

    public function testDeleteUtilisateur()
    {
        $this->setIdUser();
        $ch = curl_init();
        $url = URL_test."/utilisateurs/$this->idUser";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($res);
        $this->assertEquals(true, $res->status);
    }
}