<?php

namespace Controller;

use Exceptions\HttpException;

class EtiquettesController extends HttpController
{
    public function __construct($getData, $postData, $url, $method)
    {
        parent::__construct($getData, $postData, $url, $method);
        $this->repository = new \Model\EtiquetteRepository();
    }

    /**
     * min url : GET /etiquettes
     * @return mixed
     * @throws HttpException
     */
    public function get()
    {
        $id = isset($this->getData[1])?$this->getData[1]:null;
        // url : GET /etiquettes/{id}
        if(preg_match('#^/etiquettes/(\d)+$#', $this->url))
            $d = $this->repository->getEtiquette($id);
        else
            throw new HttpException(400,'L\'appel n\'est pas reconnu. Il se peut que le format soit errone.');
        if($d == false)
            throw new HttpException(404, 'Aucune ligne selectionnee. ');
        return $d;
    }

    /**
     * url : POST /etiquettes + POST params
     * @return string
     * @throws HttpException
     */
    public function post()
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
    public function delete()
    {
        $id = isset($this->getData[1])?$this->getData[1]:null;
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
     * url : PUT etiquettes/{id} + PUT params
     * @return string
     * @throws HttpException
     */
    public function put()
    {
        $id = isset($this->getData[1])?$this->getData[1]:null;
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