<?php

$api = new Api\Core\SimpleAPI();

$requestData = json_decode(file_get_contents('php://input'), true);

$result = $api->sessionSubscribe($requestData["sessionId"], $requestData["userEmail"]);

echo $result;