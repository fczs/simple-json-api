<?php

include_once($_SERVER["DOCUMENT_ROOT"] . '/api/classes/simpleAPI.class.php');

$requestData = json_decode(file_get_contents('php://input'), true);

$api = new simpleAPI();

$result = $api->getTable($requestData["table"], $requestData["id"]);

echo $result;