<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', "salahngcv2004");
define("DB_NAME", "to do list");
$con = new mysqli(DB_HOST,
    DB_USER,
    DB_PASS,
    DB_NAME);
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

?>