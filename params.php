<?php
$env = 'prod';

if($env == 'local') {
    define('DB_NAME', 'projet_liste');
    define('DB_PASSWORD', '');
    define('DB_USER', 'root');
    define('DB_HOST', 'localhost');
    define('URL_test', 'http://localhost/projet-liste/main.php');
}
else {
    define('DB_NAME', 'api-liste_db');
    define('DB_PASSWORD', 'paxwwwww');
    define('DB_HOST', 'mysql-api-liste.alwaysdata.net');
    define('DB_USER', 'api-liste');
    define('URL_test', 'http://api-liste.alwaysdata.net/api/v1');
}