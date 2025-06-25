<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $message = $_POST['subject'];
    
    // Aquí puedes agregar la lógica para enviar el correo
    // Por ejemplo, usando mail() o una librería como PHPMailer
    
    // Por ahora, solo redirigimos con un mensaje de éxito
    $_SESSION['message'] = "¡Gracias por tu mensaje! Te responderemos pronto.";
    header("Location: upload.php#contact");
    exit;
} else {
    header("Location: upload.php");
    exit;
}
?> 