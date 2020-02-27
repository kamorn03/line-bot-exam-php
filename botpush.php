<?php



require "vendor/autoload.php";

$access_token = 'okmwARN83ASD+J8WQfHVzMG+PdtWIQQRTGUUzoUxHtCkH/rAS2O65etqTGUOOe6TKOtUAMvBcrkISpgU3CaJzx3ZMBKb2dFqblVFQ+rG1U7AFwJ6+fZG2dOFKSnkZvx0XMa1ZNTurLgzFiDjX2roAQdB04t89/1O/w1cDnyilFU=';

$channelSecret = '013bc801bae9a9ef71d4c04de53e5caf';

$pushID = 'Uf666d81fbe662a6910f51d2d98046d32';

$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($access_token);
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $channelSecret]);


//$message = 'hello world'

$message = '{
  "to": '.$pushID.',
  "messages": [
    {
      "type": "text",
      "text": "Hello Quick Reply!",
      "quickReply": {
        "items": [
          {
            "type": "action",
            "action": {
              "type": "cameraRoll",
              "label": "Camera Roll"
            }
          },
          {
            "type": "action",
            "action": {
              "type": "camera",
              "label": "Camera"
            }
          },
          {
            "type": "action",
            "action": {
              "type": "location",
              "label": "Location"
            }
          },
          {
            "type": "action",
            "imageUrl": "https://cdn1.iconfinder.com/data/icons/mix-color-3/502/Untitled-1-512.png",
            "action": {
              "type": "message",
              "label": "Message",
              "text": "Hello World!"
            }
            },
          {
            "type": "action",
            "action": {
              "type": "postback",
              "label": "Postback",
              "data": "action=buy&itemid=123",
              "displayText": "Buy"
            }
            },
          {
            "type": "action",
            "imageUrl": "https://icla.org/wp-content/uploads/2018/02/blue-calendar-icon.png",
            "action": {
              "type": "datetimepicker",
              "label": "Datetime Picker",
              "data": "storeId=12345",
              "mode": "datetime",
              "initial": "2018-08-10t00:00",
              "max": "2018-12-31t23:59",
              "min": "2018-08-01t00:00"
            }
          }
        ]
      }
    }
   ]
}';

$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($message);
$response = $bot->pushMessage($pushID, $textMessageBuilder);

echo $response->getHTTPStatus() . ' ' . $response->getRawBody();







