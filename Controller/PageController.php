<?php

namespace Controller;


class PageController
{
    /**
     * Affiche la page d'accueil de l'api
     */
    public function action() {
        $path = str_replace('\\', '/',__DIR__.'/../View/index.html');
        echo file_get_contents($path);
    }
}