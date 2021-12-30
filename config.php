<?php

    define('DB', parse_url(getenv("CLEARDB_DATABASE_URL")));
    define('DB_SERVER', DB["host"]);
    define('DB_USERNAME', DB["user"]);
    define('DB_PASSWORD', DB["pass"]);
    define('DB_NAME', substr(DB["path"], 1));
    
    $active_group = 'default';
    $query_builder = TRUE;
 
    // Attempt to connect to MySQL database
    try{
    $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
 
    //Set fetch default
    $pdo -> setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
 
    //Allows limit
 
        /* $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); */
 
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e){
    die("ERROR: Could not connect. " . $e->getMessage());
    }
   
?>
