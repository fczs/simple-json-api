<?php

include_once($_SERVER["DOCUMENT_ROOT"] . '/api/config.php');

class SimpleAPI
{
    // DB connect parameters
    private $host = "localhost";
    private $login = DB_LOGIN;
    private $password = DB_PASSWORD;
    private $name = "test_task";
    private $encoding = "utf8";


    // On any initialization check if POST method is used for API access
    function __construct()
    {
        if ($_SERVER['REQUEST_METHOD'] != "POST") {
            die($this->getErrorMessage("Use POST to get data"));
        }
    }

    // API error messages
    private function getErrorMessage($message)
    {
        $response = json_encode(
            array(
                "status" => "error",
                "payload" => array(),
                "message" => $message
            ), JSON_UNESCAPED_UNICODE
        );
        return $response;
    }

    // API response data
    private function getOkMessage($payload = array(), $message)
    {
        $response = array(
            "status" => "ok",
            "payload" => $payload,
            "message" => $message
        );
        if (!$message) {
            array_pop($response);
        }
        $response = json_encode($response, JSON_UNESCAPED_UNICODE);
        return $response;
    }

    // Method for DB connection
    private function connectDB()
    {
        $mysqli = new mysqli($this->host, $this->login, $this->password, $this->name);
        if ($mysqli->connect_error) {
            // Throw error message if connection isn't established
            die($this->getErrorMessage($mysqli->connect_error));
        }
        $mysqli->set_charset($this->encoding);
        return $mysqli;
    }

    // Execute DB query
    private function executeDBQuery($query)
    {
        $mysqli = $this->connectDB();
        $resultDB = $mysqli->query($query) or die($this->getErrorMessage($mysqli->error . " => " . $query));
        $mysqli->close();

        return($resultDB);
    }

    // Escape special characters in the parameters strings to prepare queries
    private function escapeString($string)
    {
        $mysqli = $this->connectDB();
        $string = $mysqli->real_escape_string($string);
        $mysqli->close();
        return($string);
    }

    // Check if user with specified email exists and return user ID
    private function checkUser($userEmail)
    {
        $userEmail = $this->escapeString($userEmail);
        $userDB = $this->executeDBQuery("SELECT ID FROM `Participant` WHERE Email='" . $userEmail . "'");
        $user = [];
        while ($row = mysqli_fetch_row($userDB)) {
            $user = $row ;
        }
        return $user;
    }

    // Public API method for getting specified table data
    public function getTable($table, $id)
    {
        if ($table) {
            // Check if table is allowed to use getTable()
            $allowTable = $this->executeDBQuery("SELECT Name FROM `AllowTable` WHERE AllowInfo=1");
            $tables = [];
            while ($row  = mysqli_fetch_row($allowTable)) {
                $tables = array_merge($tables, $row);
            }
            if (in_array($table, $tables)) {
                $table = $this->escapeString($table);
                $id = $this->escapeString($id);
                $query = "SELECT * FROM `$table`" . ($id ? " WHERE id=$id" : '');
                $resultDB = $this->executeDBQuery($query);
                $result = [];
                while ($tmp = mysqli_fetch_assoc($resultDB)) {
                    $result[] = $tmp;
                }
                $response = $this->getOkMessage($result);

                return $response;
            } else {
                die($this->getErrorMessage("getTable() is not allowed for this table or table doesn't exist."));
            }
        } else {
            die($this->getErrorMessage("Need to specify table."));
        }
    }

    // Public API method for performing sessions subscribe
    public function sessionSubscribe($sessionId, $userEmail)
    {
        // Check if user is registered and get user ID
        $user = $this->checkUser($userEmail);
        if ($user) {
            $sessionId = $this->escapeString($sessionId);
            // Get limit of subscribers for specified session
            $sessionMaxUsersDB = $this->executeDBQuery("SELECT MaxParticipants FROM `Session` WHERE ID='" . $sessionId . "'");
            $sessionMaxUsers = [];
            while ($row = mysqli_fetch_row($sessionMaxUsersDB)) {
                $sessionMaxUsers = $row ;
            }
            // Get all session subscribes to check if specified user is already registered
            $sessionDB = $this->executeDBQuery("SELECT * FROM `SessionSubscribe` WHERE SessionID='" . $sessionId . "'");
            $session = [];
            while ($tmp = mysqli_fetch_assoc($sessionDB)) {
                if ($user[0] == $tmp["ParticipantId"]) {
                    die($this->getErrorMessage("You have already registered for this session."));
                } else {
                    $session[] = $tmp;
                }
            }

            // Register user for session if limit of subscribes isn't reached
            if ($sessionMaxUsers[0] > count($session)) {
                $query = "INSERT INTO `SessionSubscribe` SET SessionID='" . $sessionId . "', ParticipantId='" . $user[0] . "'";
                $resultDB = $this->executeDBQuery($query);

                if ($resultDB) {
                    $response = $this->getOkMessage(array(), "Thank you, you have successfully registered!");
                    return $response;
                }
            } else {
                die($this->getErrorMessage("Sorry, we are completely filled out."));
            }
        } else {
            die($this->getErrorMessage("The email address is not registered."));
        }
    }

    // Public API method for posting news
    public function postNews($userEmail, $newsTitle, $newsMessage)
    {
        $user = $this->checkUser($userEmail);
        if ($user) {
            $newsTitle = $this->escapeString($newsTitle);
            $newsMessage = $this->escapeString($newsMessage);
            // Check if user has already posted specified item
            $newsDB = $this->executeDBQuery("SELECT 1 FROM `News` WHERE ParticipantId='" . $user[0] . "' AND NewsTitle='" . $newsTitle . "' LIMIT 1");
            if (mysqli_fetch_row($newsDB)) {
                die($this->getErrorMessage("This item has been posted earlier."));
            }

            $query = "INSERT INTO `News` SET ParticipantId='" . $user[0] . "', NewsTitle='" . $newsTitle . "', NewsMessage='" . $newsMessage . "'";
            $resultDB = $this->executeDBQuery($query);

            if ($resultDB) {
                $response = $this->getOkMessage(array(), "Thank you, we've got your news!");
                return $response;
            }
        } else {
            die($this->getErrorMessage("The email address is not registered."));
        }
    }
}