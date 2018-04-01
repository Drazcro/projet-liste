<?php

namespace Controller;

use Exceptions\HttpException;

class ElementsController extends HttpController
{
    public function __construct($getData, $postData, $method)
    {
        parent::__construct($getData, $postData, $method);
        $this->repository = new \Model\ElementRepository();
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
     * Min url : GET /elements
     * @return mixed
     * @throws HttpException
     */
    private function get()
    {
        $id = $this->getData[1];
        //url : GET /elements/{id}
        if(sizeof($this->getData) == 2 && isset($id) && !empty($id))
            $d = $this->repository->getElement($id);
        else
            throw new HttpException(400, 'L\'id n\'est pas indique.');
        return $d;
    }

    /**
     * url : POST /elements + POST params
     * @return string
     * @throws HttpException
     */
    private function post()
    {
        if(isset($this->postData['date_creation']) && isset($this->postData['date_modif']) && isset($this->postData['titre']) && isset($this->postData['description']) && isset($this->postData['statut']) && isset($this->postData['idListe']))
            $d = $this->repository->createElement($this->postData['date_creation'], $this->postData['date_modif'], $this->postData['titre'], $this->postData['description'], $this->postData['statut'], $this->postData['idListe']);
        else
            throw new HttpException(400, 'Un des attributs entre pour la requete n\'est pas bien defini ou n\'est pas fourni.');
        if(!$d)
            throw new HttpException(500, 'L\'ajout a echoue.');
        else
            return "L\'ajout a reussie.";
    }

    /**
     * url : DELETE /elements/{id]
     * @return string
     * @throws HttpException
     */
    private function delete()
    {
        $id = $this->getData[1];
        if(isset($id) && !empty($id))
            $d = $this->repository->deleteElement($id);
        else
            throw new HttpException(400, 'L\'id n\'est pas definie.');
        if(!$d)
            throw new HttpException(500, 'La suppression a echoue.');
        else
            return "La suppression a reussie.";
    }

    /**
     * url : PUT /elements/{id}
     * @return string
     * @throws HttpException
     */
    private function put()
    {
        $id = $this->getData[1];
        if(isset($this->postData['date_creation']) && isset($this->postData['date_modif']) && isset($this->postData['titre']) && isset($this->postData['description']) && isset($this->postData['statut']) && isset($this->postData['idListe']) && isset($id) && !empty($id))
            $d = $this->repository->updateElement($this->postData['date_creation'], $this->postData['date_modif'], $this->postData['titre'], $this->postData['description'], $this->postData['statut'], $this->postData['idListe'], $id);
        else
            throw new HttpException(400, 'Un des attributs entre pour la requete n\'est pas bien defini ou n\'est pas fourni.');
        if(!$d)
            throw new HttpException(500, 'La mise a jour a echoue.');
        else
            return "La mise a jour reussie.";
    }
}