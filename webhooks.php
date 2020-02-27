<?php // callback.php

require "vendor/autoload.php";
require_once('vendor/linecorp/line-bot-sdk/line-bot-sdk-tiny/LINEBotTiny.php');

$access_token = 'okmwARN83ASD+J8WQfHVzMG+PdtWIQQRTGUUzoUxHtCkH/rAS2O65etqTGUOOe6TKOtUAMvBcrkISpgU3CaJzx3ZMBKb2dFqblVFQ+rG1U7AFwJ6+fZG2dOFKSnkZvx0XMa1ZNTurLgzFiDjX2roAQdB04t89/1O/w1cDnyilFU=';

// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			// Get text sent
			$text = $event['source']['userId'];
			// Get replyToken
			$replyToken = $event['replyToken'];

            $quick_reply = array(
                'items' => [
                    'type'=> 'action',
                    'action'=> [
                        'type' => "cameraRoll",
                        'label' => "Camera Roll"
                    ],
                ],
                [
                    'type'=> 'action',
                    'action'=> [
                        'type' => "camera",
                        'label' => "camera"
                    ],
                ]
            );


			// Build message to reply back
			$messages = [
				'type' => 'text',
				'text' => $text,
                //'quickReply'=> $quick_reply
			];


			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			$data = [
				'replyToken' => $replyToken,
				'messages' => [$messages]
			];

            // json CURLOPT_POSTFIELDS
            $json_quick = '{
                  "to": '.$event['source']['userId'].',
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


			$post = json_encode($data);

           // $post = $json_quick;


			$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Content-Type: text/plain'));
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$result = curl_exec($ch);
			curl_close($ch);

			echo $result . "\r\n";
		}
	}
}
echo "OK";
