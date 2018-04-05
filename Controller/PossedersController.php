<?php

namespace Controller;

use Exceptions\HttpException;

class PossedersController extends HttpController
{
    public function __construct($getData, $postData, $url, $method)
    {
        parent::__construct($getData, $postData, $url, $method);
        $this->repository = new \Model\PossederRepository();
    }

    /**
     * min url : GET /posseders
     * @return mixed
     * @throws HttpException
     */
    public function get()
    {
        $idListe1 = isset($this->getData[1])?$this->getData[1]:null;
        $idListe2 = isset($this->getData[2])?$this->getData[2]:null;
        //url : GET /posseders/{idListe1]/{idListe2}
        if(preg_match('#^/posseders/(\d)+/(\d)+$#', $this->url))
            $d = $this->repository->getPosseder($idListe1, $idListe2);
        else
            throw new HttpException(400,'L\'appel n\'est pas reconnu. Il se peut que le format soit errone.');
        if($d == false)
            throw new HttpException(404, 'Aucune ligne selectionnee.');
        return $d;
    }

    /**
     * url : POST /posseders + POST params
     * @return string
     * @throws HttpException
     */
    public function post()
    {
        if(isset($this->postData['idListe1']) && isset($this->postData['idListe2']))
            $d = $this->repository->createPosseder($this->postData['idListe1'], $this->postData['idListe2']);
        else
            throw new HttpException(400, 'Un des attributs entre pour la requete n\'est pas bien defini ou n\'est pas fourni.');
        if(!$d)
            throw new HttpException(500, 'L\'ajout a echoue.');
        else
            return "L\'ajout a reussie.";
    }

    /**
     * url : DELETE /posseders/{idListe1]/{idListe2}
     * @return string
     * @throws HttpException
     */
    public function delete()
    {
        $idListe1 = isset($this->getData[1])?$this->getData[1]:null;
        $idListe2 = isset($this->getData[2])?$this->getData[2]:null;
        if(isset($idListe1) && !empty($idListe1) && isset($idListe2) && !empty($idListe2))
            $d = $this->repository->deletePosseder($idListe1, $idListe2);
        else
            throw new HttpException(400, 'L\'id n\'est pas definie.');
        if(!$d)
            throw new HttpException(500, 'La suppression a echoue.');
        else
            return "La suppression a reussie.";
    }

    /**
     * url : PUT /posseders/{idListe1]/{idListe2} + PUT params
     * @return string
     * @throws HttpException
     */
    public function put()
    {
        $idListe1 = isset($this->getData[1])?$this->getData[1]:null;
        $idListe2 = isset($this->getData[2])?$this->getData[2]:null;
        if(isset($idListe1) && !empty($idListe1) && isset($idListe2) && !empty($idListe2) && isset($this->postData['newIdListe1']) && isset($this->postData['newIdListe2']))
            $d = $this->repository->updatePosseder($idListe1, $idListe2, $this->postData['newIdListe1'], $this->postData['newIdListe2']);
        else
            throw new HttpException(400, 'Un des attributs entré pour la requete n\'est pas bien defini ou n\'est pas fourni.');
        if(!$d)
            throw new HttpException(500, 'La mise a jour a echoue.');
        else
            return "La mise a jour reussie.";
    }
}