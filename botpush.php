<?php



require "vendor/autoload.php";

$access_token = 'okmwARN83ASD+J8WQfHVzMG+PdtWIQQRTGUUzoUxHtCkH/rAS2O65etqTGUOOe6TKOtUAMvBcrkISpgU3CaJzx3ZMBKb2dFqblVFQ+rG1U7AFwJ6+fZG2dOFKSnkZvx0XMa1ZNTurLgzFiDjX2roAQdB04t89/1O/w1cDnyilFU=';

$channelSecret = '013bc801bae9a9ef71d4c04de53e5caf';

$pushID = 'Uf666d81fbe662a6910f51d2d98046d32';

$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($access_token);
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $channelSecret]);


$message = 'HELLO';


$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($message);
$response = $bot->pushMessage($pushID, $textMessageBuilder);

echo $response->getHTTPStatus() . ' ' . $response->getRawBody();







