<?php

$token = getenv('BOT_TOKEN');
$website = 'https://api.telegram.org/bot' . $token;

$input = file_get_contents('php://input');
$update = json_decode($input, TRUE);

if (isset($update['message'])) {
    $chatId = $update['message']['chat']['id'];
    $message = $update['message']['text'];
    switch ($message) {
        case '/start':
            $responseText = '¡Bot ha sido iniciado con exito, ¿En que puedo ayudarte?!';
            $keyboard = [
                'keyboard' => [['info', 'Hola!']],
                'resize_keyboard' => true,
                'one_time_keyboard' => true
            ];
            $replyMarkup = json_encode($keyboard);
            send_message($chatId, $responseText, 'Markdown', $replyMarkup);
            exit;
            break;

        case 'info':
            $response = 'Bot creado en PHP y montado en el servidor Render';
            send_message($chatId, $response);
            break;

        case 'Hola!':
            $response = '¡Hola, soy el Bot creado por Jaime, Brissa y Valeria!';
            send_message($chatId, $response);
            break;

        default:
            $response = 'No te he entendido (PHP en Render)';
            send_message($chatId, $response);
            break;
    }
}

function send_message($chat_id, $response_text, $parse_mode = 'Markdown', $reply_markup = null) {
    global $website;
    $url = $website . '/sendMessage?chat_id=' . $chat_id . '&text=' . urlencode($response_text) . '&parse_mode=' . $parse_mode;
    if ($reply_markup) {
        $url .= '&reply_markup=' . urlencode($reply_markup);
    }
    file_get_contents($url);
}

?>
