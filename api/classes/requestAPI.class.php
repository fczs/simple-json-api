<?php

class requestAPI
{
    private $_url = "http://35.156.37.59/api/";
    
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
    
    public function testAPI($method, $params)
    {
        $result = file_get_contents($this->_url . $method . "/", false, $this->createContext($params));
        $result = json_decode($result);
        $result = (array)$result;

        return $result;
    }
}