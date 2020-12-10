<?php

function db_connect() {
    try {
        $connection = new PDO('mysql:host='.DB_SERVER.'; dbname='.DB_NAME, DB_USER, DB_PASS); 
        return $connection;
    }
    
    catch(Exception $e) {
        echo $e->getMessage();
    }

    function db_disconnect($connection) {
        if(isset($connection)) {
            $connection->close();
        }
    }
    
}
