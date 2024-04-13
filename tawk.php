<?php

// Clave secreta del webhook
$webhookSecret = 'c49518fbe1083708cb6773f47dfd9958076bb5506d5aca7c5da5a9e39484c63b8e153e18645149cf3118dbe4dde4c426';

// Verificar la integridad de la carga útil del webhook
function verifySignature($body, $signature)
{
    global $webhookSecret;

    $digest = hash_hmac('sha1', $body, $webhookSecret);
    return $signature === $digest;
}

// Procesar la carga útil del webhook si la firma HMAC es válida
if (isset($_SERVER['HTTP_X_TAWK_SIGNATURE']) && verifySignature(file_get_contents('php://input'), $_SERVER['HTTP_X_TAWK_SIGNATURE'])) {
    // Procesar la carga útil del webhook
    $data = json_decode(file_get_contents('php://input'), true);
    if ($data && isset($data['event'])) {
        switch ($data['event']) {
            case 'ticket.created':
                // Procesar el evento de ticket creado
                $ticket = $data['data'];
                // Procesar el ticket
                break;
            default:
                // Ignorar otros eventos
                break;
        }
    }
} else {
    // Responder con un código de estado HTTP 401 Unauthorized
    http_response_code(401);
}

?>