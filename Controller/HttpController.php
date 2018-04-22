<?php

namespace Controller;

use Utils\HttpResponse;

abstract class HttpController
{
    protected $method;
    protected $getData;
    protected $postData;
    protected $url;
    protected $pseudo;
    protected $password;

    public function __construct ($getData, $postData, $url, $method, $pseudo, $password) {
        $this->method = $method;
        $this->getData = $getData;
        $this->postData = $postData;
        $this->pseudo = $pseudo;
        $this->password = $password;
        $this->url = $url;
    }

    /**
     * Envoit la réponse http
     * @param $message
     */
    public function httpResponse($message)
    {
        $r = new HttpResponse();
        $r->json_response($message);
    }

    /**
     * Envoi la réponse http d'accès refusé
     */
    public function httpDeniedResponse() {
        $r = new \Utils\HttpResponse();
        $r->json_response('Vous n\'etes pas autorise', 403);
    }

    /**
     * Choisi quelle methode appeler selon la methode de la requête
     */
    public function action()
    {
        if($this->isAuthentified()) {
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
        else
            $this->httpDeniedResponse();
    }

    /**
     * Verifie ques les identifiants communique sont valides
     * @return bool
     */
    private function isAuthentified() {
        $user = null;
        if(isset($this->pseudo) && isset($this->password) && !empty($this->pseudo) && !empty($this->password)) {
            $userRepository = new \Model\AppliAuthModel();
            $user = $userRepository->getAppByPseudoPassword($this->pseudo, $this->password);
        }
        return (isset($user) && !empty($user))?true:false;
    }

    /**
     * Gère les requête de récupération d'infos
     * @return mixed
     */
    abstract protected function get();

    /**
     * Gère les requête de création d'infos
     * @return mixed
     */
    abstract protected function post();

    /**
     * Gère les requête de mise à jour d'infos
     * @return mixed
     */
    abstract protected function put();

    /**
     * Gère les requête de suppression d'infos
     * @return mixed
     */
    abstract protected function delete();
}