<?php
////Config Database
//define('DB_HOST', 'mariadbzoo.internal');
//define('DB_USER', 'fotostation_usr');
//define('DB_PASS', 'F065pV31XUyCGVLc');
//define('DB_NAME', 'fotostation2');
//define('ENCRYPTION_KEY', 'c2d1ef8b74bcddd');
//Config Database
//define('DB_HOST', 'localhost');
//define('DB_USER', 'anto');
//define('DB_PASS', 'ciao');
//define('DB_NAME', 'cosa');
//define('ENCRYPTION_KEY', 'c2d1ef8b74bcddd');

$host = $_SERVER['HTTP_HOST'];
if ($host == 'fotostation2.carbonara') {
define('DB_HOST', 'localhost');
define('DB_USER', 'anto');
define('DB_PASS', 'ciao');
define('DB_NAME', 'cosa');
define('ENCRYPTION_KEY', 'c2d1ef8b74bcddd');
}
else {
    define('DB_HOST', 'mariadbzoo.internal');
    define('DB_USER', 'fotostation_usr');
    define('DB_PASS', 'F065pV31XUyCGVLc');
    define('DB_NAME', 'fotostation2');
    define('ENCRYPTION_KEY', 'c2d1ef8b74bcddd');
}