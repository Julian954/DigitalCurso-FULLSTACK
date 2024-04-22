<?php
// Verificar si el evento es una creación de ticket
    
    $currentDateTime = date("Y-m-d H:i:s");
    //$apimessage = 'Tawk Ticket Id: ' . $ticket_id . PHP_EOL . $message;
    
    // GLPI API REST Endpoint URL
    $GLPI_API_URL = "https://demoglpi.alsainformatica.com.mx/apirest.php";
    // GLPI API User Token
    $GLPI_API_USER_TOKEN = "S6dODrsMnMsqMjWZlZpUV25QZYHWsjKyQ7Vy6Nhh";
    // GLPI API Application Token
    $GLPI_API_APP_TOKEN = "4ZvghnWdF4DmnlpYxrKLAP5KySnPNmnMrGf5rp36";
    // Request headers for GLPI API requests
    $headers = array(
        "Content-Type: application/json"
    );
    
    //Todas las peticiones a la api de glpi estando hosteado se realizan mandando los tokens directamente en el url y no en los headers.
    
    //Peticion a la api para el session token
    $URLSESSION = $GLPI_API_URL . "/initSession?user_token=" . $GLPI_API_USER_TOKEN . "&app_token=" . $GLPI_API_APP_TOKEN;
    
    // Connect to GLPI API using the specified endpoint URL and tokens
    $sessionToken2 = file_get_contents($URLSESSION, false, stream_context_create(array(
        'http' => array(
            'method' => 'GET',
            'header' => $headers
        )
    )));
    
    // Session Token
    $sessionToken2 = json_decode($sessionToken2, true);
    $sessionToken2 = $sessionToken2['session_token'];

//Peticion de creacion de ticket

    $headers = array(
        "Content-Type: application/json",
    );

    $data = array(
        "input" => array(
            "name" => "22-04-pruebas",         //Titulo
            "entitie" => "5",           //ID Entidad (Terceros)
            "date" => $currentDateTime, //Fecha
            "status" => "1",            //ID Estado (Nuevo)
            "content" => "poop",   //Descripcion
            "urgency" => "3",           //ID Urgencia
            "impact" => "3",            //ID Impacto
            "priority" => "3",          //ID Prioridad
            "type" => "2",              //ID tipo 
            "requesttype" => "9",       //ID Origen
            "itilcategory" => "25",     //ID Categoria
            "locations_id" => "5"    //ID Tercero
        )
    );

    $json = json_encode($data);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_URL, $GLPI_API_URL . "/Ticket?session_token=" . $sessionToken2 . "&app_token=" . $GLPI_API_APP_TOKEN);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);
    curl_close($ch);
    
    // Guardar los datos del ticket en un archivo de registro
    //$log_entry = "Ticket ID: $ticket_id, Fecha: $fecha, Requester: $reqname, Subject: $subject, Message: $apimessage, SessionId: $sessionToken2 , Tocket: $response";
    //file_put_contents('registro_tickets.log', $log_entry . PHP_EOL, FILE_APPEND);
    

// Respondiendo con éxito
http_response_code(200);

?>