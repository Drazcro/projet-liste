<?php

namespace Controller;

use Utils\HttpResponse;

abstract class HttpController
{
    protected $method;
    protected $getData;
    protected $postData;
    protected $urlData;
    protected $url;

    public function __construct ($getData, $postData, $url, $method) {
        $this->method = $method;
        $this->getData = $getData;
        $this->postData = $postData;
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
     * Choisi quelle methode appeler selon la methode de la requête
     */
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