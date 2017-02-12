<?php

include_once($_SERVER["DOCUMENT_ROOT"] . '/api/Core/SimpleAPI.php');

$api = new SimpleAPI();

$requestData = json_decode(file_get_contents('php://input'), true);

$result = $api->sessionSubscribe($requestData["sessionId"], $requestData["userEmail"]);

echo $result;