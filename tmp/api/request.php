<?php

namespace api;

//include_once($_SERVER["DOCUMENT_ROOT"] . '/api/classes/requestAPI.class.php');

$request = new RequestAPI();

$tArray = array(
    "table" => "News",
    "id" => "0"
);

$result = $request->testAPI("table", $tArray);

echo '<pre>';
print_r($result);
echo '</pre>';

$sArray = array(
    "sessionId" => "123",
    "userEmail" => "mail@yandex.ru"
);

$result = $request->testAPI("sessionSubscribe", $sArray);

echo '<pre>';
print_r($result);
echo '</pre>';

$nArray = array(
    "userEmail" => "corruptsouls@gmail.co",
    "newsTitle" => "У нас новая новость",
    "newsMessage" => "На самом деле нет"
);

$result = $request->testAPI("postNews", $nArray);

echo '<pre>';
print_r($result);
echo '</pre>';