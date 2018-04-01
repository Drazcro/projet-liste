<?php

namespace Controller;

use Exceptions\HttpException;

class PartagesController extends HttpController
{
    public function __construct($getData, $postData, $method)
    {
        parent::__construct($getData, $postData, $method);
        $this->repository = new \Model\PartageRepository();
    }

    public function action()
    {
        if($this->method == 'GET')
            $d=$this->get();
        elseif ($this->method == 'POST')
            $d=$this->post();
        elseif ($this->method == 'DELETE')
            $d=$this->delete();
        elseif ($this->method == 'PUT')
            $d=$this->put();
        $this->httpResponse($d);
    }

    /**
     * min url : GET /partages
     * @return mixed
     * @throws HttpException
     */
    private function get()
    {
        $idUser= $this->getData[1];
        $idListe = $this->getData[2];
        //url : GET /partages/{idUser}/{idListe}
        if(sizeof($this->getData) == 3 && isset($idUser) && !empty($idUser) && isset($idListe) && !empty($idListe))
            $d = $this->repository->getPartage($idUser, $idListe);
        else
            throw new HttpException(400, 'L\'id n\'est pas indique.');
        return $d;
    }

    /**
     * url : POST /partages + POST params
     * @return string
     * @throws HttpException
     */
    private function post()
    {

        if(isset($this->postData['utilisateur_idUser']) && isset($this->postData['liste_idliste']) && isset($this->postData['autorisation']))
            $d = $this->repository->createPartage($this->postData['utilisateur_idUser'], $this->postData['liste_idliste'], $this->postData['autorisation']);
        else
            throw new HttpException(400, 'Un des attributs entre pour la requete n\'est pas bien defini ou n\'est pas fourni.');
        if(!$d)
            throw new HttpException(500, 'L\'ajout a echoue.');
        else
            return "L\'ajout a reussie.";
    }

    /**
     * url : DELETE /partages/{idUser}/{idListe}
     * @return string
     * @throws HttpException
     */
    private function delete()
    {
        $idUser= $this->getData[1];
        $idListe = $this->getData[2];
        if(isset($idUser) && !empty($idUser) && isset($idListe) && !empty($idListe))
            $d = $this->repository->deletePartage($idUser, $idListe);
        else
            throw new HttpException(400, 'L\'id n\'est pas definie.');
        if(!$d)
            throw new HttpException(500, 'La suppression a echoue.');
        else
            return "La suppression a reussie.";
    }

    /**
     * url PUT /partages/{idUser}/{idListe}
     * @return string
     * @throws HttpException
     */
    private function put()
    {
        $idUser= $this->getData[1];
        $idListe = $this->getData[2];
        if(isset($idUser) && !empty($idUser) && isset($idListe) && !empty($idListe) && isset($this->postData['newIdUser']) && isset($this->postData['newIdListe']) && isset($this->postData['autorisation']))
            $d = $this->repository->updatePartage($idUser, $idListe, $this->postData['autorisation'], $this->postData['newIdUser'], $this->postData['newIdListe']);
        else
            throw new HttpException(400, 'Un des attributs entre pour la requete n\'est pas bien defini ou n\'est pas fourni.');
        if(!$d)
            throw new HttpException(500, 'La mise a jour a echoue.');
        else
            return "La mise a jour reussie.";
    }
}