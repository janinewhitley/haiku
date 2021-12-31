<?php

    require("uri.php");

    $cleardb_url = parse_url(getenv("CLEARDB_DATABASE_URL"));

    $cleardb_server = $cleardb_url["host"];
    $cleardb_username = $cleardb_url["user"];
    $cleardb_password = $cleardb_url["pass"];
    $cleardb_db = substr($cleardb_url["path"],1);

    
    $active_group = 'default';
    $query_builder = TRUE;
    
    $dsn = "mysql:host=$cleardb_server;dbname=$cleardb_db";
    $options = array(
        PDO::ATTR_PERSISTENT => true,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
        //Allows limit
            /* $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); */
    );

    // Attempt to connect to MySQL database
    try{
        $pdo = new PDO($dsn, $cleardb_username, $cleardb_password, $options);
    } catch(PDOException $e){
        die("ERROR: Could not connect. " . $e->getMessage());
    }
   
?>
