<?php

namespace Log;

Class Logger
{
    /**
     * Log des infos de la requête
     * @param $method
     * @param $table
     * @param $getData
     * @param $postData
     */
    public function log($method, $table, $getData, $postData) {

        if(isset($getData) && !empty($getData))
            $getData = implode('+',$getData);
        else
            $getData = null;
        if(isset($postData) && !empty($postData))
            $postData = implode('+',$postData);
        else
            $postData = null;
        $path = str_replace('\\', '/', __DIR__.'/requests.log');
        $current = file_get_contents($path);
        $date = new \DateTime();
        $date->setTimestamp($_SERVER['REQUEST_TIME']);
        $date = $date->format('m/d/y H:m:s');
        $current.="$date [$method] | table : $table | GET : $getData | POST : $postData \n";
        file_put_contents($path, $current);
    }
}