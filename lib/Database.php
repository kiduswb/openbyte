<?php

// Database.php
// Handles database connections and queries

function mysqlQuery($query, $params = []) 
{
    $dsn = sprintf(
        "mysql:host=%s;dbname=%s;charset=utf8mb4",
        $_ENV['DB_HOST'],
        $_ENV['DB_NAME']
    );

    try 
    {
        $db = new PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASS'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_PERSISTENT => false,
        ]);

        $stmt = $db->prepare($query);
        $stmt->execute($params);

        // Check if the query is a SELECT or a data-modifying query
        if (preg_match('/^\s*(SELECT|SHOW|DESCRIBE|EXPLAIN)\s/i', $query)) 
            return $stmt->fetchAll(); 
        
        return $stmt->rowCount();
    } 
    
    catch (PDOException $e) {
        //!TODO: Implement logging here
        // error_log($e->getMessage());
        echo $e->getMessage();
        return false;
    }
}
