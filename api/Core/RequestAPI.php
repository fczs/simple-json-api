<?php

include_once($_SERVER["DOCUMENT_ROOT"] . '/api/config.php'); // Require constant GATE

class RequestAPI
{
    // API gate parameters
    private $gate = GATE;

    private function createContext($params = array())
    {
        $options = array(
            "http" => array(
                "method" => "POST",
                "header" => "Content-Type: application/json; charset=utf-8",
                "content" => json_encode($params)
            )
        );
        return stream_context_create($options);
    }
    
    public function request($method, $params)
    {
        $result = file_get_contents($this->gate . $method, false, $this->createContext($params));
        $result = json_decode($result);
        $result = (array)$result;
        return $result;
    }

    public function showResult($result)
    {
        echo '<pre>';
        print_r($result);
        echo '</pre>';
    }
}