<?php
 

 
$token = '8172992017:AAHptfDGYOMyv2GVArO0szjOks0hHpvV-AQ';
$chat_id = '-1003187194468';

 
function enviarTelegram($message) {
    global $token, $chat_id;

    $url = "https://api.telegram.org/bot$token/sendMessage";

    $data = [
        'chat_id' => $chat_id,
        'text' => $message,
        'parse_mode' => 'HTML'   
    ];

    $options = [
        'http' => [
            'method'  => 'POST',
            'header'  => "Content-Type:application/x-www-form-urlencoded\r\n",
            'content' => http_build_query($data),
            'timeout' => 5
        ]
    ];

    $context  = stream_context_create($options);
    $result = @file_get_contents($url, false, $context);

    if ($result === FALSE) {
        
        return false;
    }

    
    $response = json_decode($result, true);
    return $response && isset($response['ok']) && $response['ok'] === true;
}
