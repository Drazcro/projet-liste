<?php

namespace Controller;


class PageController
{
    public function action() {
        $path = str_replace('\\', '/',__DIR__.'/../View/index.html');
        echo file_get_contents($path);
    }
}