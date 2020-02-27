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

			$json_quick = '{
              "type": "text",
              "text": "Select your favorite food category or send me your location!",
              "quickReply": {
                "items": [
                  {
                    "type": "action",
                    "imageUrl": "https://example.com/sushi.png",
                    "action": {
                      "type": "message",
                      "label": "Sushi",
                      "text": "Sushi"
                    }
                  },
                  {
                    "type": "action",
                    "imageUrl": "https://example.com/tempura.png",
                    "action": {
                      "type": "message",
                      "label": "Tempura",
                      "text": "Tempura"
                    }
                  },
                  {
                    "type": "action", 
                    "action": {
                      "type": "location",
                      "label": "Send location"
                    }
                  }
                ]
              }
            }';

			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			$data = [
				'replyToken' => $replyToken,
				'messages' => [$messages]
			];

			//$post = json_encode($data);
            $post = $json_quick;

			$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$result = curl_exec($ch);
			curl_close($ch);

			echo $result . "\r\n";
		}
	}
}
echo "OK";
