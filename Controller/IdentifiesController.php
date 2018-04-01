<?php

namespace Controller;

use Exceptions\HttpException;

class IdentifiesController extends HttpController
{
    public function __construct($getData, $postData, $method)
    {
        parent::__construct($getData, $postData, $method);
        $this->repository = new \Model\IdentifieRepository();
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
     * min url : GET /identifies
     * @return mixed
     * @throws HttpException
     */
    private function get()
    {
        //url : GET /identifies/{idElements}/{idEtiquette}
        $idElements = $this->getData[1];
        $idEtiquette = $this->getData[2];
        if(sizeof($this->getData) == 3 && isset($idElements) && !empty($idElements) && isset($idEtiquette) && !empty($idEtiquette))
            $d = $this->repository->getIdentifie($idElements, $idEtiquette);
        else
            throw new HttpException(400, 'L\'id n\'est pas indique.');
        return $d;
    }

    /**
     * url : POST /identifies + POST params
     * @return string
     * @throws HttpException
     */
    private function post()
    {
        if(isset($this->postData['element_idElements']) && isset($this->postData['etiquette_idEtiquette']))
            $d = $this->repository->createIdentifie($this->postData['element_idElements'], $this->postData['etiquette_idEtiquette']);
        else
            throw new HttpException(400, 'Un des attributs entre pour la requete n\'est pas bien defini ou n\'est pas fourni.');
        if(!$d)
            throw new HttpException(500, 'L\'ajout a echoue.');
        else
            return "L\'ajout a reussie.";
    }

    /**
     * url : DELETE /identifies/{idElements}/{idEtiquette}
     * @return string
     * @throws HttpException
     */
    private function delete()
    {
        $idElements = $this->getData[1];
        $idEtiquette = $this->getData[2];
        if(isset($idElements) && !empty($idElements) && isset($idEtiquette) && !empty($idEtiquette))
            $d = $this->repository->deleteIdentifie($idElements, $idEtiquette);
        else
            throw new HttpException(400, 'L\'id n\'est pas definie.');
        if(!$d)
            throw new HttpException(500, 'La suppression a echoue.');
        else
            return "La suppression a reussie.";
    }

    /**
     * url : PUT /identifies/{idElements}/{idEtiquette}
     * @return string
     * @throws HttpException
     */
    private function put()
    {
        $idElements = $this->getData[1];
        $idEtiquette = $this->getData[2];
        if(isset($idElements) && !empty($idElements) && isset($idEtiquette) && !empty($idEtiquette) && isset($this->postData['newIdElements']) && isset($this->postData['newIdEtiquette']))
            $d = $this->repository->updateIdentifie($idElements, $idEtiquette, $this->postData['newIdElements'], $this->postData['newIdEtiquette']);
        else
            throw new HttpException(400, 'Un des attributs entré pour la requete n\'est pas bien defini ou n\'est pas fourni.');
        if(!$d)
            throw new HttpException(500, 'La mise a jour a echoue.');
        else
            return "La mise a jour reussie.";
    }
}