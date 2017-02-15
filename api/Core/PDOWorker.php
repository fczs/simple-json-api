<?php

class PDOWorker
{
    // Singleton instance
    private static $PDOInstance;

    // Creates a PDO connection to a MySQL data base
    public function __construct($dbHost, $dbName, $charset, $dbUser, $dbPassword)
    {
        if (!self::$PDOInstance) {
            self::$PDOInstance = new PDO('mysql:host=' . $dbHost . ';dbname=' . $dbName . ';charset=' . $charset, $dbUser, $dbPassword);
            // This is the default mode, but it is represented here to show that the script flow doesn't terminate
            // on connection error, we will break it later
            self::$PDOInstance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
            // Disable emulated prepared statement when using the MySQL driver
            self::$PDOInstance->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        }
        return self::$PDOInstance;
    }

    // Fetch the SQLSTATE associated with the last operation on the database handle
    public function errorCode()
    {
        return self::$PDOInstance->errorCode();
    }

    // Fetch extended error information associated with the last operation on the database handle
    public function errorInfo()
    {
        return self::$PDOInstance->errorInfo();
    }

    // Prepares a statement for execution and returns a statement object
    public function prepare($statement)
    {
        return self::$PDOInstance->prepare($statement);
    }

    // Executes an SQL statement, returning a result set as a PDOStatement object
    public function query($statement)
    {
        return self::$PDOInstance->query($statement);
    }

    // Execute query and return one row in assoc array
    public function queryFetchRowAssoc($statement)
    {
        return self::$PDOInstance->query($statement)->fetch(PDO::FETCH_ASSOC);
    }

    // Execute query and return all rows in assoc array
    public function queryFetchAllAssoc($statement)
    {
        return self::$PDOInstance->query($statement)->fetchAll(PDO::FETCH_ASSOC);
    }

    // Execute query and select one column only
    public function queryFetchColAssoc($statement)
    {
        return self::$PDOInstance->query($statement)->fetchColumn();
    }

    // Quotes a string for use in a query
    public function quote($string)
    {
        return self::$PDOInstance->quote($string);
    }
}