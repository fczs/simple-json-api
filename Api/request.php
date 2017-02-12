<?php
$request = new Api\Core\RequestAPI();

// Testing table() method
$requestData = array(
    "table" => "News",
    "id" => "0"
);
$result = $request->request("table", $requestData);
$request->showResult($result);

// Testing sessionSubscribe() method
$requestData = array(
    "sessionId" => "123",
    "userEmail" => "mail@yandex.ru"
);
$result = $request->request("sessionSubscribe", $requestData);
$request->showResult($result);

// Testing postNews() method
$requestData = array(
    "userEmail" => "corruptsouls@gmail.co",
    "newsTitle" => "We've got news",
    "newsMessage" => "Actually no"
);
$result = $request->request("postNews", $requestData);
$request->showResult($result);