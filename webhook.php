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

// Ruta del directorio de origen
$directorioOrigen = '/dist';

// Ruta del directorio de destino
$directorioDestino = '../';

// Abre el directorio de origen
if ($gestorDirectorio = opendir($directorioOrigen)) {
    // Recorre cada archivo en el directorio de origen
    while (false !== ($nombreArchivo = readdir($gestorDirectorio))) {
        // Ignora los directorios "." y ".."
        if ($nombreArchivo != "." && $nombreArchivo != "..") {
            // Crea la ruta completa de origen y destino para el archivo
            $rutaOrigen = $directorioOrigen . $nombreArchivo;
            $rutaDestino = $directorioDestino . $nombreArchivo;

            // Mueve el archivo a la nueva ubicación
            if (rename($rutaOrigen, $rutaDestino)) {
                echo "El archivo '$nombreArchivo' se ha movido correctamente.<br>";
            } else {
                echo "Error al mover el archivo '$nombreArchivo'.<br>";
            }
        }
    }

    // Cierra el directorio de origen
    closedir($gestorDirectorio);
} else {
    echo "No se pudo abrir el directorio de origen '$directorioOrigen'.<br>";
}

// Puedes agregar más acciones, como notificar por correo electrónico o reiniciar servicios si es necesario.

echo "Despliegue exitoso!";
?>