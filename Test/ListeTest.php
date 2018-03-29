<?php

namespace Test;

use PHPUnit\Framework\TestCase;

class ListeTest extends TestCase
{
    public function testCreate() {
        $ch = curl_init();
        $post = ['table'=>'liste', 'function'=>'createListe', 'description'=>'uneliste', 'title'=>'maliste', 'idUser'=>1, 'visibility'=>1];
        $url = "localhost/projet-liste/main.php";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, TRUE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        $res = curl_exec($ch);
        var_dump($res);
        curl_close($ch);
    }
}