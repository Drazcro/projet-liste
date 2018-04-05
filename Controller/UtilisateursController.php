<?php

namespace Controller;

use Exceptions\HttpException;

class UtilisateursController extends HttpController
{
    public function __construct($getData, $postData, $url, $method)
    {
        parent::__construct($getData, $postData, $url, $method);
        $this->repository = new \Model\UtilisateurRepository();
    }

    /**
     * min url : GET /utilisateurs
     * @return mixed
     * @throws HttpException
     */
    public function get()
    {
        $param = isset($this->getData[1])?$this->getData[1]:null;
        // url : GET /utilisateurs
        if(preg_match('#^/utilisateurs$#', $this->url))
            $d = $this->repository->getAllUtilisateur();
        // url : GET /utilisateurs/{id|pseudo}
        elseif(preg_match('#^/utilisateurs/(.)*$#', $this->url))
                $d = $this->repository->getUtilisateur($param);
        // url : GET /utilisateurs/(.)*/(\d)*
        elseif(preg_match('#^/utilisateurs/(.)*/(\d)*$#', $this->url))
            $d = $this->repository->getUtilisateurByPseudoPassword($this->getData[1], $this->getData[2]);
        else
            throw new HttpException(400,'L\'appel n\'est pas reconnu. Il se peut que le format soit errone.');
        if($d == false)
            throw new HttpException(404, 'Aucune ligne selectionnee.');
        return $d;
    }

    /**
     * url : POST /utilisateurs + POST params
     * @return string
     * @throws HttpException
     */
    public function post()
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
    public function delete()
    {
        $id = isset($this->getData[1])?$this->getData[1]:null;
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
     * url : PUT / utilisateurs/{id} + PUT params
     * @return string
     * @throws HttpException
     */
    public function put()
    {
        $id = isset($this->getData[1])?$this->getData[1]:null;
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