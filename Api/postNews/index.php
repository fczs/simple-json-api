<?php

$api = new Api\Core\SimpleAPI();

$requestData = json_decode(file_get_contents('php://input'), true);

$result = $api->postNews($requestData["userEmail"], $requestData["newsTitle"], $requestData["newsMessage"]);

echo $result;