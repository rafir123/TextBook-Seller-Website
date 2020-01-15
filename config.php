<?php

/**
 *  Configuration for database connection
 *  Modify this to fit your DB connection
 */

$db_host = "127.0.0.1:8889";
$db_username = "root";
$db_password = "root";
$db_name = "BookSeller"; // will use later
$dsn = "mysql:host=$db_host;dbname=$db_name"; // will use later
$db_options = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
);
