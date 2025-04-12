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
            $response = '¡Me has iniciado desde PHP en Render!';
            $keyboard = [
                'keyboard' => [['info'], ['Hola!', 'que haces?'], ['como crees que te ira en la sumativa:']],
                'resize_keyboard' => true,
                'one_time_keyboard' => true
            ];
            $response = json_encode(['text' => $response, 'reply_markup' => $keyboard]);
            send_message($chatId, $response);
            exit; // Importante para no enviar la respuesta por defecto
            break;

        case 'info':
            $response = '*Información del bot PHP en Render*\nEste es un bot de prueba.';
            break;

        case 'Hola!':
            $response = '¡Hola a ti también desde Render!';
            break;

        case 'que haces?':
            $response = '_Estoy corriendo en Render y listo para automatizar!_';
            break;

        case 'como crees que te ira en la sumativa:':
            $response = 'Con *PHP* y en `Render`, ¡seguro que super bien!';
            break;

        default:
            $response = 'No te he entendido (PHP en Render)';
            break;
    }

    // ------------------------------------------------------------------------
    // Función para enviar el mensaje de respuesta a Telegram
    // ------------------------------------------------------------------------

    function send_message($chat_id, $response_text, $parse_mode = 'Markdown') {
        global $website;
        $url = $website . '/sendMessage?chat_id=' . $chat_id . '&text=' . urlencode($response_text) . '&parse_mode=' . $parse_mode;
        file_get_contents($url);
    }

    // ------------------------------------------------------------------------
    // Enviar la respuesta
    // ------------------------------------------------------------------------

    send_message($chatId, $response);
}

?>