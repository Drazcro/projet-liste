<?php

namespace Controller;

use Exceptions\HttpException;

class UtilisateursController extends HttpController
{
    public function __construct($getData, $postData, $method)
    {
        parent::__construct($getData, $postData, $method);
        $this->repository = new \Model\UtilisateurRepository();
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
     * min url : GET /utilisateurs
     * @return mixed
     * @throws HttpException
     */
    private function get()
    {
        $id = $this->getData[1];
        // url : GET /utilisateurs/{id}
        if(sizeof($this->getData) == 2 && isset($id) && !empty($id))
            $d = $this->repository->getUtilisateur($id);
        else
            throw new HttpException(400, 'L\'id n\'est pas indique.');
        return $d;
    }

    /**
     * url : POST /utilisateurs + POST params
     * @return string
     * @throws HttpException
     */
    private function post()
    {
        if(isset($this->postData['pseudo']) && isset($this->postData['password']) && isset($this->postData['permission']) && isset($this->postData['role']))
            $d = $this->repository->createUtilisateur($this->postData['pseudo'], $this->postData['password'], $this->postData['permission'], $this->postData['role']);
        else
            throw new HttpException(400, 'Un des attributs entre pour la requete n\'est pas bien defini ou n\'est pas fourni.');
        if(!$d)
            throw new HttpException(500, 'L\'ajout a echoue.');
        else
            return "L\'ajout a reussie.";
    }

    /**
     * url : DELETE /utilisateurs/{id}
     * @return string
     * @throws HttpException
     */
    private function delete()
    {
        $id = $this->getData[1];
        if( isset($id) && !empty($id))
            $d = $this->repository->deleteUtilisateur($id);
        else
            throw new HttpException(400, 'L\'idUser n\'est pas definie.');
        if(!$d)
            throw new HttpException(500, 'La suppression a echoue.');
        else
            return "La suppression a reussie.";
    }

    /**
     * url : PUT / utilisateurs/{id}
     * @return string
     * @throws HttpException
     */
    private function put()
    {
        $id = $this->getData[1];
        if(isset($this->postData['pseudo']) && isset($this->postData['password']) && isset($this->postData['permission']) && isset($this->postData['role']) && isset($id) && !empty($id))
            $d = $this->repository->updateUtilisateur($this->postData['pseudo'], $this->postData['password'], $this->postData['permission'], $this->postData['role'], $id);
        else
            throw new HttpException(400, 'Un des attributs entré pour la requete n\'est pas bien defini ou n\'est pas fourni.');
        if(!$d)
            throw new HttpException(500, 'La mise a jour a echoue.');
        else
            return "La mise a jour reussie.";
    }
}