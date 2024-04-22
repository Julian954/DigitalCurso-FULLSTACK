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

    // NOMBRE DE LA UBICACION 
    $LocatName = "JC MINERÍA";

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


    //Peticion de Location
    $headers = array(
        "Content-Type: application/json"
    );

    $url =$GLPI_API_URL . "/Location?session_token=" . $sessionToken2 . "&app_token=" . $GLPI_API_APP_TOKEN . "&range=0-15000";
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);

    if ($response === false) {
        echo "Error en la solicitud cURL: " . curl_error($ch);
    } else {
        // Verificar si hubo algún error en la respuesta
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($http_status !== 200) {
            echo 'Error al realizar la solicitud: HTTP ' . $http_status;
        } else {
            // Decodificar la respuesta JSON
            $locations = json_decode($response, true);

            // Verificar si la decodificación fue exitosa
            if ($locations === null) {
                echo 'Error al decodificar la respuesta JSON';
            } else {
                // Buscar el ID de la entidad por su nombre
                $UbiId = findLocationIdByName($locations,$LocatName);
                if ($UbiId === null) {
                    echo 'No se encontró la entidad por el nombre especificado';
                }
            }
        }
    }

    curl_close($ch);

    /**
     * Find Location ID by name.
     * Returns Location id if match else null.
     * @param array $locations 
     * @return int|null
     */
    function findLocationIdByName($locations,$LocatName) {
        // Si no se encuentra la entidad, devuelve el id de la entidad "Infraestructura de Terceros" que es la default
        foreach ($locations as $locat) {
            if (like_match('%'. $LocatName .'%',$locat['name']) == 1) {
                return $locat['id'];
            }
        }
        return null; // Si no se encuentra la entidad por defecto
    }

    /**
     * SQL Like operator in PHP.
     * Returns TRUE if match else FALSE.
     * @param string $pattern (comparacion)
     * @param string $subject (string a comparar)
     * @return bool
     */
    function like_match($pattern, $subject)
    {
        $pattern = str_replace('%', '.*', preg_quote($pattern, '/'));
        return (bool) preg_match("/^{$pattern}$/i", $subject);
    }

    echo "El id de la ubicacion es: " . $UbiId;

//Peticion de creacion de ticket

    $headers = array(
        "Content-Type: application/json",
    );

    $data = array(
        "input" => array(
            "name" => "22-04-pruebas Con Locations",         //Titulo
            "entitie" => "5",           //ID Entidad (Terceros)
            "date" => $currentDateTime, //Fecha
            "status" => "1",            //ID Estado (Nuevo)
            "content" => "boba",   //Descripcion
            "urgency" => "3",           //ID Urgencia
            "impact" => "3",            //ID Impacto
            "priority" => "3",          //ID Prioridad
            "type" => "2",              //ID tipo 
            "requesttype" => "9",       //ID Origen
            "itilcategory" => "25",     //ID Categoria
            "locations_id" => $UbiId    //ID Tercero
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