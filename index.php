<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Caroline Sada Finance</title>
    <!-- Bootstrap CSS from CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container" id="inicio">
            <img src="img\logo.svg" class="img-fluid" alt="Banner promocional" loading="lazy">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#hero">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contacto">Contacto</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#cursos">Cursos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">Sobre Nosotros</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <header id="hero" class="bg-dark text-white py-4">
        <div class="container">
            <h1 class="mb-0">Bienvenidos a Caroline Finance</h1>
        </div>
    </header>

    <main>
        <section class="hero py-5">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6" style="min-height: 50px; width: 50%;"> 
                        <h2>¡Descubre cómo mejorar tus finanzas!</h2>
                        <p>Aprende consejos valiosos y conceptos financieros importantes para tu emprendimiento, mandanos un correo con tus dudas para ayudarte.</p>
                        <a href="#contacto" class="btn btn-primary">Contactar</a>
                    </div>
                    <div class="col-md-6" style="min-height: 30px;">
                        <img src="img/img1.svg" class="img-fluid" alt="Banner promocional" loading="lazy">
                    </div>
                    
                </div>
            </div>
        </section>
        <section class="hero py-5">
            <div class="container">
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
                                    echo $ticket;
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
            </div>
        </section>

        <section id="cursos" class="courses py-5">
            <div class="container">
                <h2>Cursos</h2>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card h-100 border-rounded">
                            <img src="img\cursos\personal-finance.svg" class="card-img-top" alt="Curso 1" loading="lazy">
                            <div class="card-body d-flex flex-column justify-content-between">
                                <h5 class="card-title">Curso de Finanzas Personales</h5>
                                <p class="card-text">Aprende a gestionar tus finanzas personales de manera efectiva.</p>
                                <a href="#" class="btn btn-primary">Ver Curso</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 border-rounded">
                            <img src="img\cursos\investments.svg" class="card-img-top" alt="Curso 2" loading="lazy">
                            <div class="card-body d-flex flex-column justify-content-between">
                                <h5 class="card-title">Curso de Inversiones</h5>
                                <p class="card-text">Descubre cómo invertir en el mercado financiero de manera inteligente.</p>
                                <a href="#" class="btn btn-primary">Ver Curso</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 border-rounded">
                            <img src="img\cursos\enterpreneur.svg" class="card-img-top" alt="Curso 3" loading="lazy">
                            <div class="card-body d-flex flex-column justify-content-between">
                                <h5 class="card-title">Curso de Emprendimiento</h5>
                                <p class="card-text">Aprende a iniciar y hacer crecer tu propio negocio.</p>
                                <a href="#" class="btn btn-primary">Ver Curso</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        

        <section id="contacto" class="contact py-5">
            <div class="container">
                <h2>Contacto</h2>
                <form action="#" method="post" class="row g-3">
                    <div class="col-md-6">
                        <label for="nombre" class="form-label">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                        <div id="emailHelp" class="form-text">Nunca compartiremos tu correo electrónico con nadie más.</div>
                    </div>
                    <div class="col-12">
                        <label for="mensaje" class="form-label">Mensaje:</label>
                        <textarea id="mensaje" name="mensaje" class="form-control" rows="4" required></textarea>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </div>
                </form>
            </div>
        </section>

        <section id="about" class="about py-5">
            <div class="container">
                <h2>Sobre Nosotros</h2>
                <p>Somos un equipo comprometido en brindarte la mejor experiencia en educación financiera.</p>
            </div>
        </section>
        <section id="garantia" class="guarantee py-5">
            <div class="container">
                <h2>Garantía de Satisfacción</h2>
                <p>Estamos seguros de la calidad de nuestro curso. Si por alguna razón no estás satisfecho con tu compra, te ofrecemos una garantía de devolución del dinero dentro de los primeros 30 días.</p>
                <p>¡Tu satisfacción es nuestra prioridad!</p>
            </div>
        </section>
    </main>

    <footer class="bg-dark text-white py-4">
        <div class="container">
            <p class="mb-0">Síguenos en:</p>
            <div class="social-icons">
                <a href="https://www.facebook.com/tucuenta" target="_blank"><img src="img\redesicons\facebook.svg" alt="Facebook"></a>
                <a href="https://twitter.com/tucuenta" target="_blank"><img src="img\redesicons\twitter-x.svg" alt="Twitter"></a>
                <a href="https://www.instagram.com/tucuenta" target="_blank"><img src="img\redesicons\instagram.svg" alt="Instagram"></a>
                <a href="https://www.tiktok.com/tucuenta" target="_blank"><img src="img\redesicons\tiktok.svg" alt="Tiktok"></a>
            </div>
            <p class="mb-0">&copy; 2024 Finanzas para Emprendedores</p>
        </div>
    </footer>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Popper.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>
    <!-- Lazy Load Script -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var lazyloadImages = document.querySelectorAll("img.lazy-load");
            var lazyloadThrottleTimeout;
            function lazyload() {
                if(lazyloadThrottleTimeout) {
                    clearTimeout(lazyloadThrottleTimeout);
                }
                lazyloadThrottleTimeout = setTimeout(function() {
                    var scrollTop = window.pageYOffset;
                    lazyloadImages.forEach(function(img) {
                        if(img.offsetTop < (window.innerHeight + scrollTop)) {
                            img.src = img.dataset.src;
                            img.classList.remove('lazy-load');
                        }
                    });
                    if(lazyloadImages.length == 0) {
                        document.removeEventListener("scroll", lazyload);
                        window.removeEventListener("resize", lazyload);
                        window.removeEventListener("orientationChange", lazyload);
                    }
                }, 20);
            }
            document.addEventListener("scroll", lazyload);
            window.addEventListener("resize", lazyload);
            window.addEventListener("orientationChange", lazyload);
        });
    </script>
    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
        (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src='https://embed.tawk.to/6619a907a0c6737bd12b465c/1hra3ohir';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
        })();
    </script>

</body>

</html>

<?php 
//Peticion de Location
$headers = array(
    "Content-Type: application/json"
);

$url =$GLPI_API_URL . "/Location?session_token=" . $sessionToken2 . "&app_token=" . $GLPI_API_APP_TOKEN . "&range=0-10000";
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
            $UbiId = findLocationIdByName($locations);
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
function findLocationIdByName($locations) {
    $reqname = "ACCE";
    // Si no se encuentra la entidad, devuelve el id de la entidad "Infraestructura de Terceros" que es la default
    foreach ($locations as $locat) {
        if (like_match('%'. $reqname .'%',$locat['name']) == 1) {
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

?>
