<?php

namespace Test;

use PHPUnit\Framework\TestCase;

require_once (__DIR__.'/../params.php');

class ApiTest extends TestCase
{
    private $idUser;
    private $idListe;
    private $idElement;
    private $pdo;

    public function __construct()
    {
        parent::__construct();
        $this->pdo = new \PDO('mysql:host=localhost;dbname='.DB_NAME, DB_USER, DB_PASSWORD);
    }

    private function setIdUser() {
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
        $stmt = $this->pdo->prepare('SELECT * FROM utilisateur WHERE pseudo = "cedric"');
        $stmt->execute();
        $d = $stmt->fetch(\PDO::FETCH_ASSOC);
        $this->idUser = $d['idUser'];
    }

    private function setIdListe() {
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
        $stmt = $this->pdo->prepare('SELECT * FROM liste WHERE idUser = '.$this->idUser);
        $stmt->execute();
        $d = $stmt->fetch(\PDO::FETCH_ASSOC);
        $this->idListe = $d['idliste'];
    }

    private function setIdElement() {
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
        $stmt = $this->pdo->prepare('SELECT * FROM element WHERE idListe = '.$this->idListe);
        $stmt->execute();
        $d = $stmt->fetch(\PDO::FETCH_ASSOC);
        $this->idElement = $d['idelements'];
    }

    public function testCreateUtilisateur() {
        $ch = curl_init();
        $post = ['table'=>'utilisateur', 'function'=>'createUtilisateur', 'pseudo'=>'cedric', 'password'=>'1234', 'permission'=>1, 'role'=>1];
        $url = "localhost/projet-liste/main.php";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        $res = json_decode(curl_exec($ch), true);
        curl_close($ch);
        $this->assertEquals(true, $res['status']);
    }

    public function testCreateListe() {
        $this->setIdUser();
        $ch = curl_init();
        $post = ['table'=>'liste', 'function'=>'createListe', 'title'=>'ma liste', 'description'=>'une description', 'visibility'=>1, 'idUser'=>$this->idUser];
        $url = "localhost/projet-liste/main.php";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        $res = json_decode(curl_exec($ch), true);
        curl_close($ch);
        $this->assertEquals(true, $res['status']);
    }

    public function testCreateElement() {
        $this->setIdUser();
        $this->setIdListe();
        $dateCrea = new \DateTime();
        $dateModif = new \DateTime();
        $ch = curl_init();
        $post = ['table'=>'element', 'function'=>'createElement', 'date_creation'=>date_format($dateCrea, 'Y-m-d H:i:s'), 'date_modif'=>date_format($dateModif, 'Y-m-d H:i:s'), 'titre'=>'un element', 'description'=>'un super element', 'statut'=>1, 'idListe'=>$this->idListe];
        $url = "localhost/projet-liste/main.php";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        $res = json_decode(curl_exec($ch), true);
        curl_close($ch);
        $this->assertEquals(true, $res['status']);
    }

    public function testGetListe() {
        $this->setIdUser();
        $this->setIdListe();
        $ch = curl_init();
        $url = "localhost/projet-liste/main.php?table=liste&function=getListe&idListe=$this->idListe";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $res = json_decode(curl_exec($ch), true);
        curl_close($ch);
        $this->assertEquals(true, $res['status']);
    }

    public function testGetElement() {
        $this->setIdUser();
        $this->setIdListe();
        $this->setIdElement();
        $ch = curl_init();
        $url = "localhost/projet-liste/main.php?table=element&function=getElement&idElement=$this->idElement";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $res = json_decode(curl_exec($ch), true);
        curl_close($ch);
        $this->assertEquals(true, $res['status']);
    }

    public function testUpdateListe() {
        $this->setIdUser();
        $this->setIdListe();
        $ch = curl_init();
        $post = ['table'=>'liste', 'function'=>'updateListe', 'idUser'=>$this->idUser, 'title'=>'ma liste 2', 'description'=>'une description 2', 'idListe'=>$this->idListe, 'visibility'=>1];
        $url = "localhost/projet-liste/main.php";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
        $res = json_decode(curl_exec($ch), true);
        curl_close($ch);
        $this->assertEquals(true, $res['status']);
    }

    public function testUpdateElement() {
        $this->setIdUser();
        $this->setIdListe();
        $this->setIdElement();
        $ch = curl_init();
        $dateCrea = new \DateTime();
        $dateModif = new \DateTime();
        $post = ['table'=>'element', 'function'=>'updateElement', 'date_creation'=>date_format($dateCrea, 'Y-m-d H:i:s'), 'date_modif'=>date_format($dateModif, 'Y-m-d H:i:s'), 'titre'=>"nouveau titre", 'description'=>'une nouvelle description', 'statut'=>1, 'idListe'=>$this->idListe, 'idElement'=> $this->idElement];
        $url = "localhost/projet-liste/main.php";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
        $res = json_decode(curl_exec($ch), true);
        curl_close($ch);
        $this->assertEquals(true, $res['status']);
    }

    public function testDeleteElement() {
        $this->setIdUser();
        $this->setIdListe();
        $this->setIdElement();
        $ch = curl_init();
        $post = ['table'=>'element', 'function'=>'deleteElement', 'idElement'=>$this->idElement];
        $url = "localhost/projet-liste/main.php";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
        $res = json_decode(curl_exec($ch), true);
        curl_close($ch);
        $this->assertEquals(true, $res['status']);
    }

    public function testDeleteListe() {
        $this->setIdUser();
        $this->setIdListe();
        $ch = curl_init();
        $post = ['table'=>'liste', 'function'=>'deleteListe', 'idListe'=>$this->idListe];
        $url = "localhost/projet-liste/main.php";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
        $res = json_decode(curl_exec($ch), true);
        curl_close($ch);
        $this->assertEquals(true, $res['status']);
    }

    public function testGetUtilisateur() {
        $this->setIdUser();
        $ch = curl_init();
        $post = ['table'=>'utilisateur', 'function'=>'getUtilisateur', 'idUser'=>$this->idUser];
        $url = "localhost/projet-liste/main.php?table=utilisateur&function=getUtilisateur&idUser=$this->idUser";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $res = json_decode(curl_exec($ch), true);
        curl_close($ch);
        $this->assertEquals(true, $res['status']);
    }

    public function testUpdateUtilisateur() {
        $this->setIdUser();
        $ch = curl_init();
        $post = ['table'=>'utilisateur', 'function'=>'updateUtilisateur', 'idUser'=>$this->idUser, 'pseudo'=>'cedric', 'password'=>'12534', 'permission'=>1, 'role'=>1];
        $url = "localhost/projet-liste/main.php";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
        $res = json_decode(curl_exec($ch), true);
        curl_close($ch);
        $this->assertEquals(true, $res['status']);
    }

    public function testDeleteUtilisateur() {
        $this->setIdUser();
        $ch = curl_init();
        $post = ['table'=>'utilisateur', 'function'=>'deleteUtilisateur', 'idUser'=>$this->idUser];
        $url = "localhost/projet-liste/main.php";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
        $res = json_decode(curl_exec($ch), true);
        curl_close($ch);
        $this->assertEquals(true, $res['status']);
    }
}