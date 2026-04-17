<?php
// Configuración básica
$para = "info@lasastreriadeltiempo.com";
$asunto = "Nuevo Diagnóstico - Sesión Express de Coaching";

// Si vas a usar PHPMailer u otra librería SMTP específica, deberás requerirla aquí.
// Ejemplo: require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Recogida y limpieza de datos
    $nombre = strip_tags(trim($_POST["nombre"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $telefono = strip_tags(trim($_POST["telefono"]));
    
    $participantes = isset($_POST["participantes"]) ? strip_tags(trim($_POST["participantes"])) : "No especificado";
    $edades_hijos = isset($_POST["edades_hijos"]) ? strip_tags(trim($_POST["edades_hijos"])) : "Ninguna/No especificado";
    
    $conflicto = strip_tags(trim($_POST["conflicto"]));
    $objetivos = strip_tags(trim($_POST["objetivos"]));
    $algo_mas = isset($_POST["algo_mas"]) ? strip_tags(trim($_POST["algo_mas"])) : "Nada extra";
    
    $privacidad = isset($_POST["privacidad"]) ? "Sí, aceptada" : "No";

    // Validar datos principales
    if (empty($nombre) || empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($conflicto)) {
        http_response_code(400);
        echo "Por favor, completa correctamente el formulario y proporciona un email válido.";
        exit;
    }

    // Construir el cuerpo del correo
    $mensaje = "Has recibido un nuevo Formulario de Diagnóstico desde la web.\n\n";
    $mensaje .= "=== 1. DATOS DEL CLIENTE ===\n";
    $mensaje .= "Nombre: $nombre\n";
    $mensaje .= "Email: $email\n";
    $mensaje .= "Teléfono: $telefono\n\n";
    
    $mensaje .= "=== 2. LA FAMILIA ===\n";
    $mensaje .= "Participantes: $participantes\n";
    $mensaje .= "Edades de los hijos: $edades_hijos\n\n";
    
    $mensaje .= "=== 3. EL CONFLICTO PRINCIPAL ===\n";
    $mensaje .= "$conflicto\n\n";
    
    $mensaje .= "=== 4. OBJETIVOS ===\n";
    $mensaje .= "$objetivos\n\n";
    
    $mensaje .= "=== 5. ALGO MÁS ===\n";
    $mensaje .= "$algo_mas\n\n";
    
    $mensaje .= "=============================\n";
    $mensaje .= "Privacidad aceptada: $privacidad\n";

    // Encabezados del correo
    $headers = "From: $nombre <$email>\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/plain; charset=utf-8\r\n";

    // ==========================================
    // NOTA PARA IMPLEMENTACIÓN SMTP:
    // Si necesitas usar una conexión SMTP real y autenticada (ej: Gmail, SendGrid, Office365), 
    // reemplaza la función mail() de abajo por la lógica de PHPMailer.
    // ==========================================
    
    if (mail($para, $asunto, $mensaje, $headers)) {
        // Redirigir a una página de éxito (puedes crear un exito.html si lo deseas o mostrar un mensaje)
        echo "<script>alert('¡Formulario enviado correctamente! En breve me pondré en contacto contigo.'); window.location.href = 'index.html';</script>";
    } else {
        http_response_code(500);
        echo "Hubo un problema al enviar tu mensaje. Por favor, inténtalo más tarde o escríbeme directamente a info@lasastreriadeltiempo.com";
    }

} else {
    // No es una petición POST
    echo "Hubo un problema con tu envío, por favor intenta de nuevo.";
}
?>
