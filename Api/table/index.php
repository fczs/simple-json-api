<?php

include_once($_SERVER["DOCUMENT_ROOT"] . '/Api/Core/SimpleAPI.php');

$api = new SimpleAPI();

$requestData = json_decode(file_get_contents('php://input'), true);

$result = $api->getTable($requestData["table"], $requestData["id"]);

echo $result;