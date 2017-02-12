<?php

include_once($_SERVER["DOCUMENT_ROOT"] . '/api/Core/SimpleAPI.php');

$api = new SimpleAPI();
$result = "";
// Get post data
$requestData = json_decode(file_get_contents('php://input'), true);
// Get method name from URI
$method = array_pop(explode("/", $_SERVER["REQUEST_URI"]));
// Choose method relatively
switch ($method) {
    case 'table':
        $result = $api->getTable($requestData["table"], $requestData["id"]);
        break;
    case 'sessionSubscribe':
        $result = $api->sessionSubscribe($requestData["sessionId"], $requestData["userEmail"]);
        break;
    case 'postNews':
        $result = $api->postNews($requestData["userEmail"], $requestData["newsTitle"], $requestData["newsMessage"]);
        break;
}
echo $result;