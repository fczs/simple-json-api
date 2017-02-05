<?php

class simpleAPI
{
    // DB connect parameters
    private $_host = "localhost";
    private $_login = "";
    private $_passphrase = "";
    private $_dbname = "test_task";
    private $_encoding = "utf8";

    function __construct()
    {
        if ($_SERVER['REQUEST_METHOD'] != "POST")
        {
            die($this->getErrorMessage("Для получения данных используйте метод POST"));
        }
    }

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

    private function getOkMessage($payload = array(), $message)
    {
        $response = array(
            "status" => "ok",
            "payload" => $payload,
            "message" => $message
        );
        if (!$message) array_pop($response);
        $response = json_encode($response, JSON_UNESCAPED_UNICODE);
        return $response;
    }

    private function executeDBQuery($query)
    {
        $link = mysqli_connect($this->_host, $this->_login, $this->_passphrase, $this->_dbname) or die($this->getErrorMessage(mysqli_error($link)));
        mysqli_set_charset($link, $this->_encoding);
        $resultDB = mysqli_query($link, $query) or die($this->getErrorMessage(mysqli_error($link) . " => " . $query));
        mysqli_close($link);

        return($resultDB);
    }

    private function checkUser($userEmail)
    {
        $userDB = $this->executeDBQuery("SELECT ID FROM `Participant` WHERE Email='" . $userEmail . "'");
        $user = [];
        while($row = mysqli_fetch_row($userDB))
        {
            $user = $row ;
        }

        return $user;
    }

    public function getTable($table, $id)
    {
        if(!$table) die($this->getErrorMessage("Не указана таблица"));

        $allowTable = $this->executeDBQuery("SELECT Name FROM `AllowTable` WHERE AllowInfo=1");
        $tables = [];
        while($row  = mysqli_fetch_row($allowTable))
        {
            $tables = array_merge($tables, $row);
        }

        if(!in_array($table, $tables)) die($this->getErrorMessage("Нет информации для данной таблицы"));

        $query = "SELECT * FROM `$table`" . ($id ? " WHERE id=$id" : '');
        $resultDB = $this->executeDBQuery($query);
        $result = [];
        while ($tmp = mysqli_fetch_assoc($resultDB))
        {
            $result[] = $tmp;
        }

        $response = $this->getOkMessage($result);
        return $response;
    }

    public function sessionSubscribe($sessionId, $userEmail)
    {
        $user = $this->checkUser($userEmail);
        if ($user)
        {
            $sessionMaxUsersDB = $this->executeDBQuery("SELECT MaxParticipants FROM `Session` WHERE ID='" . $sessionId . "'");
            $sessionMaxUsers = [];
            while ($row = mysqli_fetch_row($sessionMaxUsersDB))
            {
                $sessionMaxUsers = $row ;
            }
            $sessionDB = $this->executeDBQuery("SELECT * FROM `SessionSubscribe` WHERE SessionID='" . $sessionId . "'");
            $session = [];
            while ($tmp = mysqli_fetch_assoc($sessionDB))
            {
                if ($user[0] == $tmp["ParticipantId"])
                    die($this->getErrorMessage("Вы уже зарегистрировались на эту сессию"));
                else
                    $session[] = $tmp;
            }

            if ($sessionMaxUsers[0] > count($session))
            {
                $query = "INSERT INTO `SessionSubscribe` SET SessionID='" . $sessionId . "', ParticipantId='" . $user[0] . "'";
                $resultDB = $this->executeDBQuery($query);

                if ($resultDB) {
                    $response = $this->getOkMessage(array(), "Спасибо, вы успешно записаны!");
                    return $response;
                }
            }
            else
                die($this->getErrorMessage("Извините, все места заняты"));
        }
        else
            die($this->getErrorMessage("Пользователь с таким email не зарегистрирован"));
    }

    public function postNews($userEmail, $newsTitle, $newsMessage)
    {
        $user = $this->checkUser($userEmail);
        if ($user)
        {
            $newsDB = $this->executeDBQuery("SELECT 1 FROM `News` WHERE ParticipantId='" . $user[0] . "' AND NewsTitle='" . $newsTitle . "' LIMIT 1");
            if (mysqli_fetch_row($newsDB)) die($this->getErrorMessage("Такая новость уже существует"));

            $query = "INSERT INTO `News` SET ParticipantId='" . $user[0] . "', NewsTitle='" . $newsTitle . "', NewsMessage='" . $newsMessage . "'";
            $resultDB = $this->executeDBQuery($query);

            if ($resultDB) {
                $response = $this->getOkMessage(array(), "Спасибо, ваша новость сохранена!");
                return $response;
            }
        }
        else
            die($this->getErrorMessage("Пользователь с таким email не зарегистрирован"));

    }
}