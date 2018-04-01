<?php

namespace Controller;

use Exceptions\HttpException;

class EtiquettesController extends HttpController
{
    public function __construct($getData, $postData, $method)
    {
        parent::__construct($getData, $postData, $method);
        $this->repository = new \Model\EtiquetteRepository();
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
     * min url : GET /etiquettes
     * @return mixed
     * @throws HttpException
     */
    private function get()
    {
        $id = $this->getData[1];
        // url : GET /etiquettes/{id}
        if(sizeof($this->getData) == 2 && isset($id) && !empty($id))
            $d = $this->repository->getEtiquette($id);
        else
            throw new HttpException(400, 'L\'id n\'est pas indique.');
        return $d;
    }

    /**
     * url : POST /etiquettes + POST params
     * @return string
     * @throws HttpException
     */
    private function post()
    {
        if(isset($this->postData['tag']) && isset($this->postData['idUser']))
            $d = $this->repository->createEtiquette($this->postData['tag'], $this->postData['idUser']);
        if(!$d)
            throw new HttpException(500, 'L\'ajout a echoue.');
        else
            return "L\'ajout a reussie.";
    }

    /**
     * url : DELETE /etiquettes/{id}
     * @return string
     * @throws HttpException
     */
    private function delete()
    {
        $id = $this->getData[1];
        if(isset($id) && !empty($id))
            $d = $this->repository->deleteEtiquette($id);
        else
            throw new HttpException(400, 'L\'id n\'est pas definie.');
        if(!$d)
            throw new HttpException(500, 'La suppression a echoue.');
        else
            return "La suppression a reussie.";
    }

    /**
     * url : PUT etiquettes/{id} + POST params
     * @return string
     * @throws HttpException
     */
    private function put()
    {
        $id = $this->getData[1];
        if(isset($this->postData['tag']) && isset($this->postData['idUser']) && isset($id) && !empty($id))
            $d = $this->repository->updateEtiquette($this->postData['tag'], $this->postData['idUser'], $id);
        else
            throw new HttpException(400, 'Un des attributs entré pour la requete n\'est pas bien defini ou n\'est pas fourni.');
        if(!$d)
            throw new HttpException(500, 'La mise a jour a echoue.');
        else
            return "La mise a jour reussie.";
    }
}