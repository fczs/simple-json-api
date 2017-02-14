<?php

class PDOWorker
{
    // Singleton instance
    static private $PDOInstance;

    // Creates a PDO connection to a MySQL data base
    public function __construct($dbHost, $dbName, $dbUser, $dbPassword)
    {
        if (!self::$PDOInstance) {
            try {
                self::$PDOInstance = new PDO('mysql:host=' . $dbHost . ';dbname=' . $dbName, $dbUser, $dbPassword);
                // This is the default mode, but it is represented here to show that the script flow doesn't terminate
                // on connection error. We will break it later.
                self::$PDOInstance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
            } catch (PDOException $e) {
                // Writes error message to a log file
                file_put_contents($_SERVER["DOCUMENT_ROOT"] . '/api/log/error.log', $e->getMessage(), FILE_APPEND);
            }
        }
        return self::$PDOInstance;
    }
}