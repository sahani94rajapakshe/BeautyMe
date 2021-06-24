<?php
header("Access-Control-Allow-Origin: *"); 
define('DB_NAME', 'app_beautyme'); // DATABASE
define('DB_USER', 'root'); // ROOT DEFAULT MYSQL
define('DB_PASSWORD', '');  // PASSOWORD
define('DB_HOST', 'localhost'); // LOCAL IF YOU USE LOCAL.

$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    date_default_timezone_set('Asia/Jakarta');
?>