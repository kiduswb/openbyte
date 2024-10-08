<?php

// Database.php
// Handles database connections and queries

/**
 * mysqlQuery
 * Sends a query to the MySQL database and returns the result.
 * Uses PDO for connection and queries.
 * @param  string $query SQL query string
 * @param  array  $params Parameters to bind to the query (optional)
 * @return array|false Query result or false on failure
 */
function mysqlQuery($query, $params = []) 
{
    $dsn = sprintf(
        "mysql:host=%s;dbname=%s;charset=utf8mb4",  // MySQL DSN format
        $_ENV['DB_HOST'],
        $_ENV['DB_NAME']
    );

    try {
        // Establish the database connection using PDO for MySQL
            $db = new PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASSWORD'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,   // Throw exceptions on errors
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Default fetch mode
            PDO::ATTR_PERSISTENT => false,                 // No persistent connection
        ]);

        // Prepare and execute the query with parameters
        $stmt = $db->prepare($query);
        $stmt->execute($params);
        // Fetch and return results
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        //!TODO: Implement logging here
        // error_log($e->getMessage());
        echo $e->getMessage();
        return false;
    }
}
