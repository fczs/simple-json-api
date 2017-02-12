<?php

include_once($_SERVER["DOCUMENT_ROOT"] . '/api/Core/RequestAPI.php');

$request = new RequestAPI();

// Keys of array represent methods names, and values are methods options
$requestData = array(
    // Testing table() method
    "table" => array(
        "table" => "News",
        "id" => "0"
    ),
    // Testing sessionSubscribe() method
    "sessionSubscribe" => array(
        "sessionId" => "123",
        "userEmail" => "mail@yandex.ru"
    ),
    // Testing postNews() method
    "postNews" => array(
        "userEmail" => "corruptsouls@gmail.co",
        "newsTitle" => "We've got news",
        "newsMessage" => "Actually no"
    )
);

// Perform all methods requests
foreach ($requestData as $k => $v) {
    $result = $request->request($k, $v);
    $request->showResult($result);
}
