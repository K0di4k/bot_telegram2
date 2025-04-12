<?php

// ----------------------------------------------------------------------------
// Configuración básica
// ----------------------------------------------------------------------------

$token = getenv('BOT_TOKEN'); // Obtener el token de una variable de entorno
$website = 'https://api.telegram.org/bot' . $token;

// ----------------------------------------------------------------------------
// Obtener y decodificar la información del webhook
// ----------------------------------------------------------------------------

$input = file_get_contents('php://input');
$update = json_decode($input, TRUE);

// ----------------------------------------------------------------------------
// Extraer información relevante del mensaje (si existe)
// ----------------------------------------------------------------------------

if (isset($update['message'])) {
    $chatId = $update['message']['chat']['id'];
    $message = $update['message']['text'];

    // ------------------------------------------------------------------------
    // Lógica de respuesta basada en el mensaje recibido
    // ------------------------------------------------------------------------

    switch ($message) {
        case '/start':
            $responseText = '¡Me has iniciado desde PHP en Render!';
            $keyboard = [
                'keyboard' => [['info'], ['Hola!', 'que haces?'], ['como crees que te ira en la sumativa:']],
                'resize_keyboard' => true,
                'one_time_keyboard' => true
            ];
            $replyMarkup = json_encode($keyboard);
            send_message($chatId, $responseText, 'Markdown', $replyMarkup); // Llamamos a send_message con el teclado
            exit; // Importante para no enviar la respuesta por defecto
            break;

        case 'info':
            $response = '*Información del bot PHP en Render*\nEste es un bot de prueba.';
            send_message($chatId, $response);
            break;

        case 'Hola!':
            $response = '¡Hola a ti también desde Render!';
            send_message($chatId, $response);
            break;

        case 'que haces?':
            $response = '_Estoy corriendo en Render y listo para automatizar!_';
            send_message($chatId, $response);
            break;

        case 'como crees que te ira en la sumativa:':
            $response = 'Con *PHP* y en `Render`, ¡seguro que super bien!';
            send_message($chatId, $response);
            break;

        default:
            $response = 'No te he entendido (PHP en Render)';
            send_message($chatId, $response);
            break;
    }
}

// ------------------------------------------------------------------------
// Función para enviar el mensaje de respuesta a Telegram
// ------------------------------------------------------------------------

function send_message($chat_id, $response_text, $parse_mode = 'Markdown', $reply_markup = null) {
    global $website;
    $url = $website . '/sendMessage?chat_id=' . $chat_id . '&text=' . urlencode($response_text) . '&parse_mode=' . $parse_mode;
    if ($reply_markup) {
        $url .= '&reply_markup=' . urlencode($reply_markup);
    }
    file_get_contents($url);
}

?>
