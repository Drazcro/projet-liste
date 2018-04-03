<?php
$env = 'local';

if($env == 'local') {
    define('DB_NAME', 'projet_liste');
    define('DB_PASSWORD', '');
    define('DB_USER', 'root');
    define('URL_test', 'http://localhost/projet-liste/main.php');
}
else {
    define('DB_NAME', 'id5080152_projetlistedb');
    define('DB_PASSWORD', 'kdknvlksdvbsdkj');
    define('DB_USER', 'id5080152_projetliste');
    define('URL_test', '');
}