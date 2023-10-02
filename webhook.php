<?php
// webhook.php
// Asegúrate de configurar la URL correcta en GitHub que apunte a este archivo

require '../../hide_html/credentials.php';

$secret = $secret_github; // Debes configurar un secreto en GitHub
$headers = getallheaders();
$hubSignature = $headers['X-Hub-Signature'];

// Verificar la firma del webhook
if ($hubSignature != "sha1=" . hash_hmac("sha1", file_get_contents("php://input"), $secret)) {
    die("Firma no válida.");
}

// Actualizar el repositorio y construir la aplicación
exec("git pull origin master");
exec("ng build --prod");

// Puedes agregar más acciones, como notificar por correo electrónico o reiniciar servicios si es necesario.

echo "Despliegue exitoso!";
?>