<?php

$api = new Api\SimpleAPI;

$requestData = json_decode(file_get_contents('php://input'), true);

$result = $api->sessionSubscribe($requestData["sessionId"], $requestData["userEmail"]);

echo $result;